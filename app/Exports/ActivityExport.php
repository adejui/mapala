<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityExport implements FromCollection, WithHeadings
{
    protected $type;
    // protected $search;

    public function __construct($type = null)
    {
        $this->type = $type;
        // $this->search = $search;
    }

    public function collection()
    {
        $query = Activity::query();

        // FILTER TYPE
        if ($this->type && $this->type != 'all') {
            $query->where('activity_type', $this->type);
        }

        // SEARCH
        // if ($this->search) {
        //     $query->where(function ($q) {
        //         $q->where('title', 'like', '%' . $this->search . '%')
        //             ->orWhere('location', 'like', '%' . $this->search . '%');
        //     });
        // }

        return $query->get()->map(function ($activity) {

            return [

                $activity->title,

                match ($activity->activity_type) {
                    'meeting' => 'Rapat',
                    'basic training' => 'Pendidikan Dasar',
                    'exploration' => 'Eksplorasi',
                    'anniversary' => 'Hari Jadi',
                    'others' => 'Lainnya',
                    default => '-',
                },

                $activity->start_date,
                $activity->end_date,
                $activity->location,
                $activity->description ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Judul Kegiatan',
            'Jenis Kegiatan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Lokasi',
            'Deskripsi',
        ];
    }
}
