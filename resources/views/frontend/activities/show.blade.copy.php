@extends('frontend.layouts.app')

@section('content')
    <div class="relative w-full h-[500px] md:h-[600px] bg-gray-900 overflow-hidden">
        
        <div class="absolute inset-0">
            <img src="{{ $activity->image ? asset('storage/' . $activity->image) : 'https://source.unsplash.com/1600x900/?mountain,adventure' }}" 
                 alt="{{ $activity->title }}" 
                 class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-t from-[#1c1c1c] via-[#1c1c1c]/50 to-transparent"></div>
        </div>

        <div class="absolute bottom-0 left-0 w-full px-6 md:px-16 pb-16 z-10">
            <div class="max-w-7xl mx-auto">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 
                    {{ $activity->activity_type == 'Rapat' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : 'bg-[#7C3AED]/20 text-[#a78bfa] border border-[#7C3AED]/30' }} backdrop-blur-md">
                    {{ $activity->activity_type }}
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
                        {{ $activity->location ?? 'Sekretariat Mapala' }}
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
                        {!! nl2br(e($activity->description)) !!}
                    </div>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-[2.5rem] p-8 md:p-10 backdrop-blur-sm">
                    <h3 class="text-2xl font-bold text-white mb-6">Dokumentasi</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="aspect-square bg-gray-700 rounded-xl overflow-hidden hover:scale-105 transition duration-500 cursor-pointer">
                            <img src="https://source.unsplash.com/400x400/?camping" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square bg-gray-700 rounded-xl overflow-hidden hover:scale-105 transition duration-500 cursor-pointer">
                            <img src="https://source.unsplash.com/400x400/?forest" class="w-full h-full object-cover">
                        </div>
                        <div class="aspect-square bg-gray-700 rounded-xl overflow-hidden hover:scale-105 transition duration-500 cursor-pointer">
                            <img src="https://source.unsplash.com/400x400/?bonfire" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-6">

                    <div class="bg-white rounded-[2rem] p-6 shadow-xl border border-gray-100 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-100 rounded-full blur-3xl -mr-16 -mt-16 transition-all group-hover:bg-purple-200"></div>

                        <h3 class="text-xl font-bold text-gray-900 mb-6 relative z-10">Detail Pelaksanaan</h3>
                        
                        <div class="space-y-5 relative z-10">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-[#7C3AED] shrink-0">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Waktu</p>
                                    <p class="text-gray-900 font-medium">
                                        {{ \Carbon\Carbon::parse($activity->start_date)->format('H:i') }} WIB - Selesai
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Lokasi</p>
                                    <p class="text-gray-900 font-medium leading-snug">
                                        {{ $activity->location ?? 'Kampus UBSI Yogyakarta' }}
                                    </p>
                                    <a href="https://maps.google.com/?q={{ $activity->location }}" target="_blank" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Lihat di Peta</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 shrink-0">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Contact Person</p>
                                    <p class="text-gray-900 font-medium">
                                        {{ $activity->cp_name ?? 'Humas Mapala' }}
                                    </p>
                                    <a href="https://wa.me/{{ $activity->cp_number ?? '628123456789' }}" target="_blank" class="text-xs text-green-600 font-bold hover:underline mt-1 inline-block">
                                        Chat WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            @if($activity->status == 'Selesai' || \Carbon\Carbon::now() > $activity->end_date)
                                <button disabled class="w-full py-3 rounded-xl bg-gray-200 text-gray-500 font-bold cursor-not-allowed">
                                    Kegiatan Selesai
                                </button>
                            @else
                                <a href="#" class="block w-full py-3.5 rounded-xl bg-[#7C3AED] text-white font-bold text-center shadow-lg hover:bg-[#6D28D9] hover:shadow-purple-500/30 hover:-translate-y-1 transition-all duration-300">
                                    <i class="fa-solid fa-user-plus mr-2"></i> Daftar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="bg-[#2a2a2a] rounded-2xl p-4 flex items-center justify-between border border-white/10">
                        <span class="text-gray-400 text-sm font-medium">Bagikan:</span>
                        <div class="flex gap-2">
                            <button class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#1DA1F2] hover:text-white text-gray-400 flex items-center justify-center transition">
                                <i class="fa-brands fa-twitter"></i>
                            </button>
                            <button class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#1877F2] hover:text-white text-gray-400 flex items-center justify-center transition">
                                <i class="fa-brands fa-facebook-f"></i>
                            </button>
                            <button class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#25D366] hover:text-white text-gray-400 flex items-center justify-center transition">
                                <i class="fa-brands fa-whatsapp"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection