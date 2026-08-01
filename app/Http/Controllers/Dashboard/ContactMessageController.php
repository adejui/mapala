<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use App\Exports\ContactMessageExport;
use Maatwebsite\Excel\Facades\Excel;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->perPage ?? 5;
        $contactMessages = $query->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.admin.messages.partials.table', compact('contactMessages'))->render();
        }

        return view('dashboard.admin.messages.index', compact('contactMessages'));
    }

    /**
     * Menampilkan detail pesan dan mengubah status menjadi dibaca.
     */
    public function show(ContactMessage $contactMessage)
    {
        // if ($contactMessage->status === 'unread') {
        //     $contactMessage->update([
        //         'status' => 'read',
        //     ]);
        // }

        // return view('dashboard.admin.messages.show', compact('contactMessage'));
    }

    /**
     * Menandai pesan sebagai sudah dibaca (dipanggil via AJAX dari modal detail).
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        if ($contactMessage->status === 'unread') {
            $contactMessage->update([
                'status' => 'read',
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => $contactMessage->status,
        ]);
    }

    /**
     * Mengekspor daftar pesan ke Excel.
     */
    public function export(Request $request)
    {
        $fileName = 'data_pesan_kontak_' . date('Y-m-d') . '.xlsx';

        return Excel::download(
            new ContactMessageExport(
                $request->search,
                $request->status
            ),
            $fileName
        );
    }

    /**
     * Menghapus pesan.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('messages.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }
}
