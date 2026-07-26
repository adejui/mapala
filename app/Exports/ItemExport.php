<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemExport implements FromCollection, WithHeadings
{
    protected $category;

    public function __construct($category = null, $search = null)
    {
        $this->category = $category;
    }

    public function collection()
    {
        $query = Item::with('category');

        // FILTER CATEGORY
        if ($this->category && $this->category != 'all') {

            $query->where('category_id', $this->category);
        }


        return $query->get()->map(function ($item) {

            return [

                $item->category->name ?? '-',
                $item->name,
                $item->code,
                $item->quantity,
                $item->description ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [

            'Kategori',
            'Nama Barang',
            'Kode Barang',
            'Jumlah',
            'Deskripsi',
        ];
    }
}
