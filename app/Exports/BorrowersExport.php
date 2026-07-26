<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BorrowersExport implements FromCollection, WithHeadings
{
    protected $campus;
    protected $organization;

    public function __construct(
        $campus = null,
        $organization = null,
    ) {
        $this->campus = $campus;
        $this->organization = $organization;
    }

    public function collection()
    {
        $query = Loan::with(['user', 'opa']);

        // FILTER KAMPUS
        if ($this->campus && $this->campus != 'all') {

            $query->whereHas('opa', function ($q) {

                $q->where(
                    'campus_name',
                    $this->campus
                );
            });
        }

        // FILTER ORGANISASI
        if ($this->organization && $this->organization != 'all') {

            $query->whereHas('opa', function ($q) {

                $q->where(
                    'organization_name',
                    $this->organization
                );
            });
        }

        return $query->get()

            ->unique(function ($loan) {

                $borrower = $loan->user ?? $loan->opa;

                return strtolower(

                    ($loan->user->full_name
                        ?? $loan->opa->name
                        ?? '') . '|' .

                        ($borrower->email ?? '') . '|' .

                        ($borrower->phone_number ?? '') . '|' .

                        ($loan->opa->campus_name ?? '') . '|' .

                        ($loan->opa->organization_name ?? '')
                );
            })

            ->map(function ($loan) {

                $borrower = $loan->user ?? $loan->opa;

                return [

                    'name' =>
                    $loan->user->full_name
                        ?? $loan->opa->name
                        ?? '-',

                    'email' =>
                    $borrower->email ?? '-',

                    'phone_number' =>
                    $borrower->phone_number ?? '-',

                    'campus_name' =>
                    $loan->opa->campus_name ?? '-',

                    'organization_name' =>
                    $loan->opa->organization_name ?? '-',

                    'type' =>
                    $loan->user ? 'Anggota' : 'Anggota Eksternal',
                ];
            })

            ->values();
    }

    public function headings(): array
    {
        return [

            'Nama',
            'Email',
            'No Telp',
            'Kampus',
            'Organisasi',
            'Tipe',
        ];
    }
}
