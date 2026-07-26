@extends('frontend.layouts.app')

@section('content')

    <div class="bg-white min-h-screen pt-32 pb-20 px-6 md:px-16">
        <div class="max-w-5xl mx-auto">

            <h3 class="text-xl font-semibold mb-6">History Peminjaman</h3>

            @forelse ($histories as $history)
                <div class="mb-6 p-4 border rounded-lg shadow-sm">

                    {{-- Info utama --}}
                    <div class="mb-3 text-sm text-gray-600">
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
                            <p class="text-sm">
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
                    @if ($history->notes)
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
