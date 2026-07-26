<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoanExport implements FromCollection, WithHeadings
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = Loan::with([
            'user',
            'opa',
            'details.item'
        ]);

        // FILTER STATUS
        if ($this->status && $this->status != 'all') {

            $query->where('status', $this->status);
        }

        return $query->get()->map(function ($loan) {

            // Gabungkan semua barang yang dipinjam
            $items = $loan->details->map(function ($detail) {

                $itemName = $detail->item->name ?? 'Barang Dihapus';

                return $itemName . ' (' . $detail->quantity . ')';
            })->implode(', ');

            return [

                // Nama Anggota
                $loan->user->full_name ?? '-',

                // Nama Anggota Eksternal
                $loan->opa->name ?? '-',

                // Barang Dipinjam
                $items ?: '-',

                // Tanggal Pinjam
                $loan->borrow_date,

                // Tanggal Kembali
                $loan->return_date,

                // Status
                match ($loan->status) {

                    'requested' => 'Menunggu Persetujuan',
                    'approved' => 'Disetujui',
                    'borrowed' => 'Dipinjam',
                    'returned' => 'Dikembalikan',
                    'rejected' => 'Ditolak',
                    'late' => 'Terlambat',

                    default => '-',
                },

                // Catatan
                $loan->notes ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [

            'Nama Anggota',
            'Nama Anggota Eksternal',
            'Barang Dipinjam',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
            'Catatan',
        ];
    }
}
