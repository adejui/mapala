<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\BorrowersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOpaRequest;
use Illuminate\Validation\Rule;
use App\Models\Opa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OpaController extends Controller
{
    /**
     * Export data peminjam.
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 5);

        $search = $request->get('search');

        $organization = $request->get('organization');
        $campus       = $request->get('campus');

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

        /*
        |--------------------------------------------------------------------------
        | QUERY OPAS
        |--------------------------------------------------------------------------
        */
        $query = Opa::query();

        // SEARCH
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // FILTER ORGANIZATION
        if ($organization && $organization !== 'all') {
            $query->whereRaw(
                'LOWER(organization_name) = ?',
                [strtolower($organization)]
            );
        }

        // FILTER CAMPUS
        if ($campus && $campus !== 'all') {
            $query->whereRaw(
                'LOWER(campus_name) = ?',
                [strtolower($campus)]
            );
        }

        $opas = $query->latest()->paginate($perPage)->appends($request->query());

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
        $validated = $request->validated();

        Opa::create($validated);

        return redirect()->route('opas.index')->with('success', 'Data peminjam berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $opa = Opa::findOrFail($id);

        return view('dashboard.admin.opas.show', compact('opa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $opa = Opa::findOrFail($id);

        return view('dashboard.admin.opas.edit', compact('opa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $opa = Opa::findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => [
                'required',
                'email',
                'max:255',
                Rule::unique('opas', 'email')->ignore($opa->id),
            ],
            'phone_number'      => 'nullable|string|max:20',
            'campus_name'       => 'nullable|string|max:255',
            'organization_name' => 'nullable|string|max:255',
        ]);

        $opa->update($validated);

        return redirect()
            ->route('opas.index')
            ->with('success', 'Data peminjam berhasil diperbarui!');
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
