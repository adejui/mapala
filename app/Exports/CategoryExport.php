<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Category::get()->map(function ($category) {

            return [

                'name' => $category->name ?? '-',

                'created_at' =>
                $category->created_at
                    ? $category->created_at->format('d-m-Y H:i')
                    : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [

            'Nama Kategori',
            'Tanggal Dibuat',
        ];
    }
}
