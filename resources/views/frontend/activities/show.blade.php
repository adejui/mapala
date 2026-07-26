@extends('frontend.layouts.app')

@section('content')
    <div class="relative w-full h-[500px] md:h-[600px] bg-gray-900 overflow-hidden">

        <div class="absolute inset-0">
            <img src="{{ asset('frontend/images/artikel-1.jpeg') }}" alt="Pendakian Masal 2025"
                class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-t from-[#1c1c1c] via-[#1c1c1c]/50 to-transparent"></div>
        </div>

        <div class="relative z-10 container mx-auto px-4 h-full mt-10">
            <div class="absolute top-20 right-4 md:right-10 text-right">

                <nav class="flex flex-wrap justify-end items-center text-sm font-medium text-gray-300">
                    <a href="{{ route('frontend.home') }}" class="hover:text-white transition-colors">
                        Home
                    </a>

                    <span class="mx-2">/</span>

                    <a href="{{ route('frontend.kegiatan') }}" class="hover:text-white transition-colors">
                        Kegiatan
                    </a>

                    <span class="mx-2">/</span>

                    <span class="text-white">
                        Detail Kegiatan
                    </span>
                </nav>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full px-6 md:px-16 pb-16 z-10">
            <div class="max-w-7xl mx-auto">
                <span
                    class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 
                    bg-[#7C3AED]/20 text-[#a78bfa] border border-[#7C3AED]/30 backdrop-blur-md">
                    {{ [
                        'meeting' => 'Rapat',
                        'basic training' => 'Pendidikan Dasar',
                        'exploration' => 'Eksplorasi',
                        'anniversary' => 'Hari Jadi',
                        'others' => 'Lainnya',
                    ][$activity->activity_type ?? ''] ?? '' }}
                </span>

                <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-4 drop-shadow-lg">
                    {{ $activity->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-6 text-gray-300 text-sm md:text-base font-medium">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-[#7C3AED]"></i>
                        {{ \Carbon\Carbon::parse($activity->start_date)->translatedFormat('l, d F Y') }}
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-[#7C3AED]"></i>
                        {{ $activity->location }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#1c1c1c] min-h-screen px-6 md:px-16 pb-20 -mt-10 relative z-20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2 space-y-10">

                <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-2xl text-gray-800 leading-relaxed">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <i class="fa-solid fa-align-left text-[#7C3AED]"></i> Tentang Kegiatan
                    </h3>
                    <div class="prose prose-purple max-w-none text-gray-600">
                        <div class="my-content">
                            {!! $activity->description !!}
                        </div>

                        <h4 class="text-lg font-bold text-gray-800 mt-6 mb-2">
                            Persyaratan Peserta:
                        </h4>

                        <style>
                            .my-content ol {
                                list-style-type: decimal !important;
                                padding-left: 24px !important;
                                margin-left: 16px !important;
                            }

                            .my-content ul {
                                list-style-type: disc !important;
                                padding-left: 24px !important;
                                margin-left: 16px !important;
                            }

                            .my-content li {
                                display: list-item !important;
                                margin-bottom: 4px;
                            }

                            .my-content ol ol,
                            .my-content ul ul,
                            .my-content ol ul,
                            .my-content ul ol {
                                margin-left: 20px !important;
                            }

                            .my-content p {
                                margin-bottom: 10px;
                            }
                        </style>

                        <div class="my-content">
                            {!! $activity->detail->participant_requirements ?? '' !!}
                        </div>
                    </div>
                </div>

                {{-- @if (\Carbon\Carbon::parse($activity->date)->isPast())
                    <div class="bg-white/5 border border-white/10 rounded-[2.5rem] p-8 md:p-10 backdrop-blur-sm">
                        <h3 class="text-2xl font-bold text-white mb-6">Dokumentasi</h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div
                                class="aspect-square bg-gray-700 rounded-xl overflow-hidden hover:scale-105 transition duration-500 cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?auto=format&fit=crop&q=80&w=400"
                                    class="w-full h-full object-cover">
                            </div>

                            <div
                                class="aspect-square bg-gray-700 rounded-xl overflow-hidden hover:scale-105 transition duration-500 cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&q=80&w=400"
                                    class="w-full h-full object-cover">
                            </div>

                            <div
                                class="aspect-square bg-gray-700 rounded-xl overflow-hidden hover:scale-105 transition duration-500 cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1533240332313-0db49b459ad6?auto=format&fit=crop&q=80&w=400"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                @endif --}}

            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-6">

                    <div
                        class="bg-white rounded-[2rem] p-6 shadow-xl border border-gray-100 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-purple-100 rounded-full blur-3xl -mr-16 -mt-16 transition-all group-hover:bg-purple-200">
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-6 relative z-10">Detail Pelaksanaan</h3>

                        <div class="space-y-5 relative z-10">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-[#7C3AED] shrink-0">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Waktu Kumpul</p>
                                    <p class="text-gray-900 font-medium">
                                        {{ $activity->detail?->start_time ? \Carbon\Carbon::parse($activity->detail->start_time)->format('H.i') : '' }}
                                        -
                                        {{ $activity->detail?->end_time ? \Carbon\Carbon::parse($activity->detail->end_time)->format('H.i') : '' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Lokasi</p>
                                    <p class="text-gray-900 font-medium leading-snug">
                                        {{ $activity->detail->location_detail ?? '' }}
                                    </p>
                                    @if ($activity->detail?->map_link)
                                        <a href="{{ $activity->detail->map_link }}" target="_blank"
                                            class="text-xs text-blue-500 hover:underline mt-1 inline-block">
                                            Lihat di Peta
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 shrink-0">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Contact Person</p>
                                    <p class="text-gray-900 font-medium">
                                        {{ $activity->detail->contact_name ?? '' }}
                                        ({{ $activity->detail->contact_role ?? '' }})
                                    </p>
                                    @if ($activity->detail?->contact_phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $activity->detail->contact_phone) }}"
                                            target="_blank"
                                            class="text-xs text-green-600 font-bold hover:underline mt-1 inline-block">
                                            Chat WhatsApp
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- @if ($activity->activity_type !== 'meeting' && \Carbon\Carbon::parse($activity->start_date)->isFuture())
                            <div class="mt-8 pt-6 border-t border-gray-100">
                                <a href="#"
                                    class="block w-full py-3.5 rounded-xl bg-[#7C3AED] text-white font-bold text-center shadow-lg hover:bg-[#6D28D9] hover:shadow-purple-500/30 hover:-translate-y-1 transition-all duration-300">
                                    <i class="fa-solid fa-user-plus mr-2"></i> Daftar Sekarang
                                </a>
                            </div>
                        @endif --}}
                    </div>

                    <div class="bg-[#2a2a2a] rounded-2xl p-4 flex items-center justify-between border border-white/10">
                        <span class="text-gray-400 text-sm font-medium">Bagikan:</span>
                        <div class="flex gap-2">
                            <button
                                class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#1DA1F2] hover:text-white text-gray-400 flex items-center justify-center transition">
                                <i class="fa-brands fa-twitter"></i>
                            </button>
                            <button
                                class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#1877F2] hover:text-white text-gray-400 flex items-center justify-center transition">
                                <i class="fa-brands fa-facebook-f"></i>
                            </button>
                            <button
                                class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#25D366] hover:text-white text-gray-400 flex items-center justify-center transition">
                                <i class="fa-brands fa-whatsapp"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
