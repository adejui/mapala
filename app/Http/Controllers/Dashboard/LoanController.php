<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\LoanExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Mail\LoanApprovedMail;
use App\Mail\LoanRejectedMail;
use App\Mail\LoanReturnedMail;
use App\Models\Category;
use App\Models\Item;
use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\Opa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function export(Request $request)
    {
        $fileName = 'data_peminjaman_' . date('Y-m-d') . '.xlsx';

        return Excel::download(
            new LoanExport(
                $request->status
            ),
            $fileName
        );
    }
    public function index(Request $request)
    {
        $opas = Opa::all();
        $users = User::whereNot('role', 'admin')->get();

        $perPage = $request->get('perPage', 5);
        $search = $request->get('search');
        $status = $request->get('status');

        $query = Loan::with(['user', 'opa'])->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {

                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('full_name', 'like', "%{$search}%");
                })
                    ->orWhereHas('opa', function ($o) use ($search) {
                        $o->where('name', 'like', "%{$search}%");
                    });
            });
        }


        if ($status && $status !== 'all') $query->where('status', $status);

        $loans = $query->paginate($perPage)->appends($request->all());

        if ($request->ajax()) {
            return view('dashboard.loans.partials.table', compact('loans'))->render();
        }

        return view('dashboard.loans.index', compact('loans', 'opas', 'users'));
    }

    public function accept($loan)
    {
        try {
            DB::transaction(function () use ($loan) {

                $loan = Loan::with(['user', 'opa', 'details.item'])->findOrFail($loan);

                foreach ($loan->details as $detail) {
                    $item = $detail->item;

                    if (!$item) {
                        throw new \Exception("Item tidak ditemukan");
                    }

                    if ($item->quantity < $detail->quantity) {
                        throw new \Exception("STOCK_INSUFFICIENT::{$item->name}");
                    }

                    $item->decrement('quantity', $detail->quantity);
                }

                $loan->update(['status' => 'approved']);

                $data = $this->buildLoanMailData($loan);

                if ($data['email']) {
                    Mail::to($data['email'])->send(new LoanApprovedMail($data));
                }
            });
        } catch (\Exception $e) {

            if (str_starts_with($e->getMessage(), 'STOCK_INSUFFICIENT::')) {
                $itemName = str_replace('STOCK_INSUFFICIENT::', '', $e->getMessage());

                return redirect()->route('loans.index')
                    ->with('stock_error', "Stok \"{$itemName}\" tidak mencukupi untuk peminjaman ini.")
                    ->with('stock_error_loan_id', $loan);
            }

            throw $e;
        }

        return redirect()->route('loans.index')
            ->with('success', 'Berhasil diACC & stok dikurangi.');
    }

    public function reject($loan)
    {
        DB::transaction(function () use ($loan) {

            $loan = Loan::with(['user', 'opa', 'details.item'])->findOrFail($loan);

            foreach ($loan->details as $detail) {
                $item = $detail->item;

                if ($item) {
                    $item->increment('quantity', $detail->quantity);
                }
            }

            $loan->update(['status' => 'rejected']);

            $data = $this->buildLoanMailData($loan);

            if ($data['email']) {
                Mail::to($data['email'])->send(new LoanRejectedMail($data));
            }
        });

        return redirect()->back()->with('success', 'Berhasil ditolak.');
    }

    public function approve($loan)
    {
        $loan = Loan::findOrFail($loan);

        $loan->update(['status' => 'borrowed']);

        return redirect()->back()->with('success', 'Berhasil dipinjam.');
    }

    // Catatan: method ini sebenarnya menandai barang SUDAH DIKEMBALIKAN,
    // namanya "borrowed" agak menyesatkan — dibiarkan sama supaya tidak
    // merusak route/pemanggilan yang sudah ada.
    public function borrowed($loan)
    {
        DB::transaction(function () use ($loan) {

            $loan = Loan::with(['user', 'opa', 'details.item'])->findOrFail($loan);

            foreach ($loan->details as $detail) {
                $item = $detail->item;

                if ($item) {
                    $item->increment('quantity', $detail->quantity);
                }
            }

            $loan->update(['status' => 'returned']);

            $data = $this->buildLoanMailData($loan);

            if ($data['email']) {
                Mail::to($data['email'])->send(new LoanReturnedMail($data));
            }
        });

        return redirect()->back()->with('success', 'Berhasil dikembalikan.');
    }

    private function buildLoanMailData(Loan $loan): array
    {
        $user = $loan->user;
        $opa  = $loan->opa;

        return [
            'id' => $loan->id,
            'name' => optional($user)->full_name ?? optional($opa)->name ?? '-',
            'email' => optional($user)->email ?? optional($opa)->email,
            'organization_name' => optional($opa)->organization_name,
            'campus_name' => optional($opa)->campus_name,
            'phone_number' => optional($user)->phone_number ?? optional($opa)->phone_number,
            'borrow_date' => $loan->borrow_date,
            'return_date' => $loan->return_date,
            'quantity' => $loan->details->sum('quantity'),
        ];
    }

    public function manage(Loan $loan)
    {
        $categories = Category::all();

        $selectedItems = LoanDetail::where('loan_id', $loan->id)
            ->pluck('item_id')
            ->toArray();

        $loanDetailsQuantity = LoanDetail::where('loan_id', $loan->id)
            ->pluck('quantity', 'item_id')  // array: item_id => quantity
            ->toArray();

        $items = Item::with('category')->where('quantity', '>=', -0)->get();


        $opas = Opa::all();
        $users = User::whereNot('role', 'admin')->get();

        return view('dashboard.loans.manage', compact('loan', 'opas', 'users', 'items', 'categories', 'selectedItems',  'loanDetailsQuantity',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanRequest $request)
    {
        // dd($request->all());

        $validated = $request->validated();

        if ($request->hasFile('loan_document')) {
            $validated['loan_document'] = $request->file('loan_document')
                ->store('loanDocuments', 'public');
        }


        Loan::create($validated);

        return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        return view('dashboard.loans.detail', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function showNotification(Loan $loan)
    {
        return view('dashboard.loans.notifikasiShow', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        // dd($request->all());

        $validated = $request->validated();

        // Jika ada dokumen baru di-upload
        if ($request->hasFile('loan_document')) {

            // Hapus file lama kalau ada
            if ($loan->loan_document && Storage::disk('public')->exists($loan->loan_document)) {
                Storage::disk('public')->delete($loan->loan_document);
            }

            // Simpan file baru
            $validated['loan_document'] = $request->file('loan_document')
                ->store('loanDocuments', 'public');
        }

        // Update data di database
        $loan->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->details()->delete();

        $loan->delete();

        return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}









    // public function accept($loan)
    // {
    //     DB::transaction(function () use ($loan) {

    //         $loan = Loan::with(['user', 'opa', 'details.item'])->findOrFail($loan);

    //         foreach ($loan->details as $detail) {

    //             $item = $detail->item;

    //             if (!$item) {
    //                 throw new \Exception("Item tidak ditemukan");
    //             }

    //             if ($item->quantity < $detail->quantity) {
    //                 throw new \Exception("Stok {$item->name} tidak cukup");
    //             }

    //             $item->decrement('quantity', $detail->quantity);
    //         }

    //         $loan->update(['status' => 'approved']);

    //         $user = $loan->user;
    //         $opa  = $loan->opa;

    //         $data = [
    //             'id' => $loan->id,
    //             'name' => optional($user)->full_name
    //                 ?? optional($opa)->name
    //                 ?? '-',

    //             'email' => optional($user)->email
    //                 ?? optional($opa)->email,

    //             'organization_name' => optional($opa)->organization_name,
    //             'campus_name' => optional($opa)->campus_name,

    //             'phone_number' => optional($user)->phone_number
    //                 ?? optional($opa)->phone_number,

    //             'borrow_date' => $loan->borrow_date,
    //             'return_date' => $loan->return_date,
    //             'quantity' => $loan->details->sum('quantity'),
    //         ];

    //         if ($data['email']) {
    //             Mail::to($data['email'])->send(new LoanApprovedMail($data));
    //         }
    //     });

    //     return redirect()->route('loans.index')
    //         ->with('success', 'Berhasil diACC & stok dikurangi.');
    // }
