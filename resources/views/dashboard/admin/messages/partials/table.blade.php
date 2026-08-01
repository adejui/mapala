<table class="min-w-full text-sm">
    <thead>
        <tr class="border-b border-gray-200 dark:border-gray-700 text-left text-gray-500 dark:text-gray-400">
            <th class="py-3 px-4 font-medium">Nama</th>
            <th class="py-3 px-4 font-medium">Email</th>
            <th class="py-3 px-4 font-medium">Subjek</th>
            <th class="py-3 px-4 font-medium">Status</th>
            <th class="py-3 px-4 font-medium">Tanggal</th>
            <th class="py-3 px-4 font-medium text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($contactMessages as $message)
            <tr
                class="border-b border-gray-100 dark:border-gray-800 {{ $message->status === 'unread' ? 'font-semibold bg-purple-50/40 dark:bg-purple-900/10' : '' }}">
                <td class="py-3 px-4 text-gray-800 dark:text-gray-100">{{ $message->name }}</td>
                <td class="py-3 px-4 text-gray-600 dark:text-gray-300">{{ $message->email }}</td>
                <td class="py-3 px-4 text-gray-600 dark:text-gray-300 truncate max-w-[220px]">{{ $message->subject }}
                </td>
                <td class="py-3 px-4">
                    <span id="status-badge-{{ $message->id }}"
                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                            {{ $message->status === 'unread'
                                ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'
                                : 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400' }}">
                        {{ $message->status === 'unread' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-gray-500 dark:text-gray-400">{{ $message->created_at->format('d M Y H:i') }}
                </td>
                <td class="py-3">
                    <div class="flex items-center justify-center">
                        <div class="flex justify-center items-center gap-2">
                            <button @click="openDetail(@js([
    'id' => $message->id,
    'name' => $message->name,
    'email' => $message->email,
    'subject' => $message->subject,
    'message' => $message->message,
    'status' => $message->status,
]))"
                                class="inline-flex items-center gap-1 rounded-lg border border-[#7653AF] px-3 py-1.5 text-xs font-medium text-[#7653AF] hover:bg-[#F3E8FF] transition dark:hover:bg-gray-800 dark:text-[#B794F4]">
                                Lihat Detail
                            </button>
                            <x-modal-confirm-delete :id="'delete-message-' . $message->id" :action="route('messages.destroy', $message->id)" :item="$message->subject" />
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="py-8 text-center text-gray-400 dark:text-gray-500">
                    Belum ada pesan masuk.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination mt-4">
    {{ $contactMessages->links() }}
</div>
