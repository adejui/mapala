@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen pt-32 pb-20 px-4 sm:px-6 md:px-16">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Riwayat Peminjaman</h1>
                    <p class="text-gray-500 mt-1 text-sm">Lihat semua aktivitas peminjaman barang kamu</p>
                </div>
                <nav class="flex text-sm font-medium text-gray-500">
                    <a href="{{ route('frontend.home') }}" class="hover:text-[#7C3AED] transition-colors">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-[#7C3AED]">Riwayat Peminjaman</span>
                </nav>
            </div>

            <div class="space-y-4">
                @forelse ($histories as $history)
                    @php
                        $totalItem = $history->details->sum('quantity');
                        $itemsPayload = $history->details->map(function ($d) {
                            return [
                                'name' => $d->item->name ?? '-',
                                'code' => $d->item->code ?? '-',
                                'qty' => $d->quantity,
                                'photo' => $d->item->photo ?? null,
                            ];
                        });
                    @endphp

                    <div
                        class="bg-white rounded-3xl border border-gray-200 px-5 sm:px-8 py-6 shadow-sm hover:shadow-md transition-shadow duration-200">

                        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900">
                                Peminjaman <span class="text-[#7C3AED]">#{{ $history->id }}</span>
                            </h3>
                            <x-status-badge :status="$history->status" />
                        </div>

                        <div
                            class="grid grid-cols-2 sm:grid-cols-4 gap-y-5 gap-x-4 text-gray-900 border-t border-gray-100 pt-5">

                            <div>
                                <div class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-1">
                                    Tanggal Pinjam
                                </div>
                                <div class="text-sm font-semibold">
                                    {{ \Carbon\Carbon::parse($history->borrow_date)->format('d M Y') }}
                                </div>
                            </div>

                            <div>
                                <div class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-1">
                                    Tanggal Kembali
                                </div>
                                <div class="text-sm font-semibold">
                                    {{ \Carbon\Carbon::parse($history->return_date)->format('d M Y') }}
                                </div>
                            </div>

                            <div>
                                <div class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-1">
                                    Total Item
                                </div>
                                <div class="text-sm font-semibold">{{ $totalItem }} Unit</div>
                            </div>

                            <div class="flex sm:justify-end items-end">
                                <button type="button"
                                    class="detail-btn w-full sm:w-auto px-5 py-2.5 rounded-xl border border-[#7C3AED]/20 text-[#7C3AED] font-semibold text-sm bg-purple-50 hover:bg-[#7C3AED] hover:text-white transition-all duration-200"
                                    data-id="{{ $history->id }}"
                                    data-borrow="{{ \Carbon\Carbon::parse($history->borrow_date)->format('d M Y') }}"
                                    data-return="{{ \Carbon\Carbon::parse($history->return_date)->format('d M Y') }}"
                                    data-status="{{ $history->status }}" data-notes="{{ $history->notes ?? '-' }}"
                                    data-total="{{ $totalItem }}" data-items='@json($itemsPayload)'>
                                    Lihat Detail
                                </button>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white rounded-3xl border border-gray-100">
                        <p class="text-gray-400 font-medium">Belum ada riwayat peminjaman.</p>
                    </div>
                @endforelse
            </div>

            <div class="pt-6">
                {{ $histories->links('vendor.pagination.tailwind-history') }}
            </div>

        </div>
    </div>

    <!-- Modal Detail Peminjaman -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">

        <div class="relative w-full max-w-2xl h-[700px] bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col">

            <!-- Header -->
            <div class="flex items-center justify-between px-8 py-6 border-b bg-white shrink-0">

                <div>
                    <h3 class="text-xl font-bold text-gray-900">
                        Detail Peminjaman
                        <span id="modalId" class="text-[#7C3AED]"></span>
                    </h3>

                    <div id="modalStatusWrapper" class="mt-2"></div>
                </div>

                <button type="button" id="closeDetailModal"
                    class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>

            <!-- Body -->
            <div class="flex-1 overflow-y-auto px-8 py-6 custom-scrollbar">

                <!-- Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-5">

                        <p class="text-xs uppercase tracking-wider font-semibold text-gray-400">
                            Tanggal Pinjam
                        </p>

                        <p id="modalBorrowDate" class="mt-2 text-base font-semibold text-gray-900">
                        </p>

                    </div>

                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-5">

                        <p class="text-xs uppercase tracking-wider font-semibold text-gray-400">
                            Tanggal Kembali
                        </p>

                        <p id="modalReturnDate" class="mt-2 text-base font-semibold text-gray-900">
                        </p>

                    </div>

                </div>

                <!-- Keperluan -->
                <div class="mb-6">

                    <h4 class="text-xs uppercase tracking-wider font-semibold text-gray-400 mb-3">
                        Keperluan Peminjaman
                    </h4>

                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                        <p id="modalNotes" class="text-sm leading-7 text-gray-700">
                        </p>

                    </div>

                </div>

                <!-- Barang -->
                <div>

                    <div class="flex justify-between items-center mb-4">

                        <h4 class="text-xs uppercase tracking-wider font-semibold text-gray-400">
                            Barang Dipinjam
                        </h4>

                        <span id="modalTotal" class="text-sm font-semibold text-[#7C3AED]">
                        </span>

                    </div>

                    <div id="modalItems" class="space-y-4">
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="border-t bg-white px-8 py-5 shrink-0">

                <button type="button" id="closeDetailModalBottom"
                    class="w-full h-12 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">

                    Tutup

                </button>

            </div>

        </div>

    </div>

    <style>
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('detailModal');
            const closeButtons = [
                document.getElementById('closeDetailModal'),
                document.getElementById('closeDetailModalBottom'),
            ];

            const statusStyles = {
                pending: {
                    label: 'Menunggu Persetujuan',
                    class: 'bg-yellow-100 text-yellow-700'
                },
                approved: {
                    label: 'Disetujui',
                    class: 'bg-blue-100 text-blue-700'
                },
                borrowed: {
                    label: 'Sedang Dipinjam',
                    class: 'bg-purple-100 text-purple-700'
                },
                returned: {
                    label: 'Sudah Dikembalikan',
                    class: 'bg-green-100 text-green-700'
                },
                rejected: {
                    label: 'Ditolak',
                    class: 'bg-red-100 text-red-700'
                },
            };

            function openModal(btn) {
                const id = btn.dataset.id;
                const borrow = btn.dataset.borrow;
                const ret = btn.dataset.return;
                const status = btn.dataset.status;
                const notes = btn.dataset.notes;
                const total = btn.dataset.total;

                let items = [];
                try {
                    items = JSON.parse(btn.dataset.items || '[]');
                } catch (e) {
                    items = [];
                }

                document.getElementById('modalId').textContent = '#' + id;
                document.getElementById('modalBorrowDate').textContent = borrow;
                document.getElementById('modalReturnDate').textContent = ret;
                document.getElementById('modalNotes').textContent = notes && notes.trim() !== '' ? notes : '-';
                document.getElementById('modalTotal').textContent = total + ' Unit';

                const statusInfo = statusStyles[status] || {
                    label: status,
                    class: 'bg-gray-100 text-gray-600'
                };
                document.getElementById('modalStatusWrapper').innerHTML =
                    `<span class="inline-block text-xs font-semibold px-3 py-1 rounded-full ${statusInfo.class}">${statusInfo.label}</span>`;

                const itemsContainer = document.getElementById('modalItems');
                itemsContainer.innerHTML = '';

                if (items.length === 0) {
                    itemsContainer.innerHTML =
                        '<p class="text-sm text-gray-400 text-center py-4">Tidak ada data barang.</p>';
                } else {
                    items.forEach(function(item) {
                        const photoUrl = item.photo ?
                            '/storage/' + item.photo :
                            '/frontend/images/tas.jpg';

                        const row = document.createElement('div');
                        row.className =
                            'flex items-center gap-4 border border-gray-100 rounded-2xl p-3';
                        row.innerHTML = `
                            <div class="h-14 w-14 shrink-0 bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center border border-gray-100">
                                <img src="${photoUrl}" class="h-full w-full object-contain mix-blend-multiply">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-gray-900 truncate">${item.name}</div>
                                <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded font-mono">#${item.code}</span>
                            </div>
                            <div class="text-sm font-bold text-[#7C3AED] shrink-0">${item.qty} Unit</div>
                        `;
                        itemsContainer.appendChild(row);
                    });
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.querySelectorAll('.detail-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    openModal(btn);
                });
            });

            closeButtons.forEach(function(btn) {
                if (btn) btn.addEventListener('click', closeModal);
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeModal();
            });
        });
    </script>
@endsection
