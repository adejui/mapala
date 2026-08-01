<?php

namespace App\Exports;

use App\Models\ContactMessage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactMessageExport implements FromCollection, WithHeadings
{
    protected $search;
    protected $status;

    public function __construct($search = null, $status = null)
    {
        $this->search = $search;
        $this->status = $status;
    }

    public function collection()
    {
        $query = ContactMessage::query();

        // FILTER SEARCH
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        // FILTER STATUS
        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->latest()->get()->map(function ($message) {

            return [

                $message->name,
                $message->email,
                $message->subject,
                $message->message,
                $message->status === 'unread' ? 'Belum Dibaca' : 'Sudah Dibaca',
                $message->created_at->format('d M Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [

            'Nama',
            'Email',
            'Subjek',
            'Pesan',
            'Status',
            'Tanggal',
        ];
    }
}
