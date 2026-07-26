<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\BorrowersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOpaRequest;
use App\Models\Loan;
use App\Models\Opa;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class OpaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function export(Request $request)
    {
        return Excel::download(

            new BorrowersExport(
                $request->campus,
                $request->organization
            ),

            'data-peminjam.xlsx_' . date('Y-m-d') . '.xlsx'
        );
    }
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 5);

        $search = $request->get('search');

        // Dropdown organizations
        $organizations = Opa::selectRaw('LOWER(organization_name) as organization_name')
            ->whereNotNull('organization_name')
            ->distinct()
            ->orderBy('organization_name', 'asc')
            ->pluck('organization_name');

        // Dropdown campuses
        $campuses = Opa::selectRaw('LOWER(campus_name) as campus_name')
            ->whereNotNull('campus_name')
            ->distinct()
            ->orderBy('campus_name', 'asc')
            ->pluck('campus_name');

        $organization = $request->get('organization');
        $campus       = $request->get('campus');

        /*
    |--------------------------------------------------------------------------
    | QUERY LOANS
    |--------------------------------------------------------------------------
    */
        $query = Loan::with(['user', 'opa'])
            ->where(function ($q) {
                $q->whereNotNull('user_id')
                    ->orWhereNotNull('opa_id');
            });

        /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */
        if ($search) {

            $query->where(function ($q) use ($search) {

                // Search user
                $q->whereHas('user', function ($user) use ($search) {
                    $user->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
                })

                    // Search opa
                    ->orWhereHas('opa', function ($opa) use ($search) {
                        $opa->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%");
                    });
            });
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER ORGANIZATION
    |--------------------------------------------------------------------------
    */
        if ($organization && $organization !== 'all') {

            $query->whereHas('opa', function ($q) use ($organization) {
                $q->whereRaw(
                    'LOWER(organization_name) = ?',
                    [strtolower($organization)]
                );
            });
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER CAMPUS
    |--------------------------------------------------------------------------
    */
        if ($campus && $campus !== 'all') {

            $query->whereHas('opa', function ($q) use ($campus) {
                $q->whereRaw(
                    'LOWER(campus_name) = ?',
                    [strtolower($campus)]
                );
            });
        }

        $opas = $query->latest()->get()
            ->unique(function ($loan) {

                $borrower = $loan->user ?? $loan->opa;

                return strtolower(
                    ($loan->user->full_name ?? $loan->opa->name ?? '') . '|' .
                        ($borrower->email ?? '') . '|' .
                        ($borrower->phone_number ?? '') . '|' .
                        ($loan->opa->campus_name ?? '') . '|' .
                        ($loan->opa->organization_name ?? '')
                );
            })
            ->values();

        $collection = $query->latest()->get()
            ->unique(function ($loan) {

                $borrower = $loan->user ?? $loan->opa;

                return strtolower(
                    ($loan->user->full_name ?? $loan->opa->name ?? '') . '|' .
                        ($borrower->email ?? '') . '|' .
                        ($borrower->phone_number ?? '') . '|' .
                        ($loan->opa->campus_name ?? '') . '|' .
                        ($loan->opa->organization_name ?? '')
                );
            })
            ->values();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $items = $collection->slice(
            ($currentPage - 1) * $perPage,
            $perPage
        )->values();

        $opas = new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        if ($request->ajax()) {
            return view('dashboard.admin.opas.partials.table', compact('opas'))->render();
        }

        return view('dashboard.admin.opas.index', compact(
            'opas',
            'organizations',
            'campuses'
        ));
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
    public function store(StoreOpaRequest $request)
    {
        // dd($request->all());

        $validated = $request->validated();

        Opa::create($validated);

        return redirect()->route('opas.index')->with('success', 'Data peminjam berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opa $opa)
    {
        $opa->delete();

        return redirect()->route('opas.index')->with('success', 'Data Peminjam berhasil dihapus!');
    }
}
