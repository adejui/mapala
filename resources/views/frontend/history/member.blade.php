@extends('frontend.layouts.app')

@section('content')
    <div class="bg-white min-h-screen pt-32 pb-20 px-6 md:px-16">

        <div class="bg-gray-50 min-h-screen pt-0 pb-20 px-6 md:px-16">
            <div class="max-w-7xl mx-auto">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5 gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Riwayat Peminjaman</h1>
                        <p class="text-gray-500 mt-1 text-sm">Lihat semua aktivitas peminjaman barang kamu</p>
                    </div>
                    <nav class="flex text-sm font-medium text-gray-500">
                        <a href="{{ route('frontend.home') }}" class="hover:text-[#7C3AED] transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-[#7C3AED]">Riwayat Peminjaman</span>
                    </nav>
                </div>
            </div>
            @forelse ($histories as $history)
                <div class="bg-white rounded-2xl border mb-2 border-gray-300 px-8 py-5">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">
                            Id Peminjaman
                        </h3>


                    </div>

                    <div class="grid grid-cols-5 text-gray-900 text-md font-semibold">
                        <div>
                            <div class="font-semibold mb-1 text-md">Tanggal Pinjam</div>
                            <div class="font-light text-sm">
                                {{ \Carbon\Carbon::parse($history->borrow_date)->format('d M Y') }}
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold mb-1 text-md text-center">Tanggal Kembali</div>
                            <div class="font-light text-sm text-center">
                                {{ \Carbon\Carbon::parse($history->return_date)->format('d M Y') }}
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold mb-1 text-md text-center">Total Item</div>
                            <div class="font-light text-sm text-center">{{ $history->details->sum('quantity') }}</div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="font-semibold text-md text-center">Status</div>
                            <div class="w-fit mt-1">
                                <x-status-badge :status="$history->status" />
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button
                                class="px-4 py-0 rounded-xl border border-gray-300 text-gray-500 font-medium bg-gray-100 hover:bg-gray-200 transition-all duration-200">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-gray-50 rounded-3xl border border-gray-100">
                    <p class="text-gray-400 font-medium">Belum ada riwayat peminjaman.</p>
                </div>
            @endforelse


        </div>
    </div>
















    <div class="max-w-5xl mx-auto">

        <h3 class="text-xl font-semibold mb-6 text-black">History Peminjaman</h3>

        @forelse ($histories as $history)
            <div class="mb-6 p-4 border rounded-lg shadow-sm">

                {{-- Info utama --}}
                <div class="mb-3 text-sm text-gray-600 space-y-1">
                    <p>
                        <span class="font-medium">Tanggal Pinjam:</span>
                        {{ \Carbon\Carbon::parse($history->borrow_date)->format('d M Y') }}
                    </p>

                    <p>
                        <span class="font-medium">Tanggal Kembali:</span>
                        {{ \Carbon\Carbon::parse($history->return_date)->format('d M Y') }}
                    </p>

                    <p>
                        <span class="font-medium">Status:</span>
                        <span class="capitalize">{{ $history->status }}</span>
                    </p>
                </div>

                {{-- Daftar item --}}
                <div class="pl-4 border-l">
                    <p class="text-sm font-medium mb-2">Item Dipinjam:</p>

                    @forelse ($history->details as $detail)
                        <p class="text-sm text-black">
                            • {{ $detail->item->name ?? '-' }}
                            <span class="text-gray-500">
                                ({{ $detail->quantity }} unit)
                            </span>
                        </p>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada item</p>
                    @endforelse
                </div>

                {{-- Catatan --}}
                @if (!empty($history->notes))
                    <p class="mt-3 text-sm text-gray-600">
                        <span class="font-medium">Catatan:</span>
                        {{ $history->notes }}
                    </p>
                @endif

            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada history peminjaman</p>
        @endforelse

    </div>
    </div>
@endsection
