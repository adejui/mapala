<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $major;
    protected $generation;

    public function __construct($status = null, $major = null, $generation = null)
    {
        $this->status = $status;
        $this->major = $major;
        $this->generation = $generation;
    }

    public function collection()
    {
        $query = User::whereNotNull('gender');

        if ($this->status && $this->status != 'all') {
            $query->where('status', $this->status);
        }

        if ($this->major && $this->major != 'all') {
            $query->where('major', $this->major);
        }

        if ($this->generation && $this->generation != 'all') {
            $query->where('generation', $this->generation);
        }

        return $query->get()->map(function ($user) {
            return [
                $user->full_name,
                $user->email,
                $user->phone_number,
                $user->nrp,
                $user->major,
                $user->generation,
                $user->batch,
                $user->birth_date,

                match ($user->status) {
                    'active' => 'Aktif',
                    'inactive' => 'Tidak Aktif',
                    'alumni' => 'Alumni',
                    default => '-',
                },

                match ($user->gender) {
                    'male' => 'Laki-laki',
                    'female' => 'Perempuan',
                    default => '-',
                },

                match ($user->position) {
                    'leader' => 'Ketua',
                    'secretary' => 'Sekretaris',
                    'logistics' => 'Logistik',
                    'member' => 'Anggota',
                    default => '-',
                },

                match ($user->role) {
                    'admin' => 'Admin',
                    'logistics' => 'Logistik',
                    'member' => 'Anggota',
                    default => '-',
                },
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'No HP',
            'NRP',
            'Jurusan',
            'Angkatan',
            'Tahun Angkatan',
            'Tanggal Lahir',
            'Status',
            'Jenis Kelamin',
            'Jabatan',
            'Role',
        ];
    }
}
