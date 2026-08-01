@extends('frontend.layouts.app')

@section('content')
    <div class="flex justify-end">
        @if (session('success'))
            <x-alert-success title="Berhasil!" :message="session('success')" />
        @endif
    </div>

    {{-- Background pola titik - statis, tidak fixed (fixed background bikin browser terus repaint saat scroll di mobile) --}}
    <div class="absolute inset-0 -z-10 bg-gray-50 opacity-60"
        style="background-image: radial-gradient(#7C3AED 0.5px, transparent 0.5px), radial-gradient(#7C3AED 0.5px, #f9fafb 0.5px); background-size: 20px 20px; background-position: 0 0, 10px 10px;">
    </div>

    <div class="min-h-screen pt-24 md:pt-32 pb-16 md:pb-20 px-4 sm:px-6 md:px-16 relative overflow-x-hidden">

        {{-- Blob dekorasi: ukuran mengecil di mobile + overflow-x-hidden di parent
             supaya nggak nambah lebar halaman & memicu scroll horizontal --}}
        <div
            class="absolute top-0 right-0 -mt-10 -mr-10 sm:-mt-20 sm:-mr-20 w-56 h-56 sm:w-72 sm:h-72 md:w-96 md:h-96 bg-purple-200/30 rounded-full pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 -mb-10 -ml-10 sm:-mb-20 sm:-ml-20 w-56 h-56 sm:w-72 sm:h-72 md:w-96 md:h-96 bg-blue-100/30 rounded-full pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto relative z-10">

            <div class="text-center mb-12 md:mb-16">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
                    Hubungi Kami
                </h1>
                <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed px-2">
                    Punya pertanyaan, saran, atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami. Tim kami siap
                    membantu Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-12 mb-16 md:mb-20 items-start">

                {{-- Card info kontak: backdrop-blur diganti solid bg putih -> visual mirip, jauh lebih ringan --}}
                <div
                    class="lg:col-span-1 w-full bg-white rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 shadow-lg shadow-purple-100/50 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 sm:mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-circle-info text-[#7C3AED]"></i> Informasi Kontak
                    </h3>

                    <div class="space-y-6 sm:space-y-8">

                        <div class="flex items-start gap-4 sm:gap-5 group">
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 shrink-0 flex items-center justify-center bg-purple-50 text-[#7C3AED] rounded-2xl group-hover:bg-[#7C3AED] group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-location-dot text-xl sm:text-2xl fa-fw"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-1">Alamat Kampus</h4>
                                <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                                    Universitas Bina Sarana Informatika (UBSI) Kampus Yogyakarta.
                                    <br>Jl. Ringroad Barat, Gamping, Sleman.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 sm:gap-5 group">
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 shrink-0 flex items-center justify-center bg-blue-50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-phone text-lg sm:text-xl fa-fw"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-1">Telepon & WhatsApp</h4>
                                <p class="text-gray-600 font-medium text-sm md:text-base">
                                    +62 812-3456-7890 (WA)
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 sm:gap-5 group">
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 shrink-0 flex items-center justify-center bg-green-50 text-green-600 rounded-2xl group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-envelope text-lg sm:text-xl fa-fw"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-1">Email Resmi</h4>
                                <p class="text-gray-600 font-medium text-sm md:text-base break-all">
                                    info@mapala-tarantula.com <br>
                                    kerjasama@mapala-tarantula.com
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 sm:gap-5 group border-t border-gray-100 pt-6 sm:pt-8 mt-2">
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 shrink-0 flex items-center justify-center bg-orange-50 text-orange-600 rounded-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-clock text-lg sm:text-xl fa-fw"></i>
                            </div>
                            <div class="min-w-0">
                                <h4
                                    class="text-base sm:text-lg font-bold text-gray-900 mb-1 flex flex-wrap items-center gap-2">
                                    <span>Jam Operasional</span>

                                    <span
                                        class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-extrabold border border-green-200 whitespace-nowrap">
                                        <span class="relative flex h-2 w-2">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                        OPEN 25/7
                                    </span>
                                </h4>

                                <p class="text-gray-600 text-sm leading-relaxed">
                                    <span class="block mb-1 font-medium">Senin - Minggu (Setiap Hari)</span>
                                    <span class="text-gray-500 text-xs">
                                        Sekretariat selalu terbuka untuk anggota. <br>
                                        <span class="italic text-[#7C3AED]">"Pantang pulang sebelum terang."</span>
                                    </span>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Card form: backdrop-blur & blob blur dihapus, ganti solid --}}
                <div
                    class="lg:col-span-2 w-full bg-white rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-8 md:p-12 shadow-lg shadow-purple-100/50 border border-gray-100 relative overflow-hidden">

                    <div class="mb-8">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-3">
                            <i class="fa-regular fa-paper-plane text-[#7C3AED]"></i>
                            Kirim Pesan Kepada Kami
                        </h3>
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-xl bg-red-100 border border-red-300 px-4 py-3 text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('frontend.contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Nama --}}
                            <div>
                                <label for="name" class="block mb-2 text-sm font-bold text-gray-700">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                        <i class="fa-regular fa-user"></i>
                                    </span>

                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Masukkan nama Anda" required
                                        class="w-full py-3.5 pl-11 pr-4 bg-gray-50 text-gray-900 placeholder-gray-400 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white">

                                </div>

                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block mb-2 text-sm font-bold text-gray-700">
                                    Alamat Email <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>

                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        placeholder="contoh@email.com" required
                                        class="w-full py-3.5 pl-11 pr-4 bg-gray-50 text-gray-900 placeholder-gray-400 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white">

                                </div>

                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Subject --}}
                        <div>
                            <label for="subject" class="block mb-2 text-sm font-bold text-gray-700">
                                Subjek Pesan <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <i class="fa-regular fa-comment-dots"></i>
                                </span>

                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                    placeholder="Apa tujuan pesan Anda?" required
                                    class="w-full py-3.5 pl-11 pr-4 bg-gray-50 text-gray-900 placeholder-gray-400 border {{ $errors->has('subject') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white">

                            </div>

                            @error('subject')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block mb-2 text-sm font-bold text-gray-700">
                                Isi Pesan <span class="text-red-500">*</span>
                            </label>

                            <textarea id="message" name="message" rows="6" placeholder="Tuliskan pesan lengkap Anda di sini..." required
                                class="w-full py-3.5 px-4 bg-gray-50 text-gray-900 placeholder-gray-400 border {{ $errors->has('message') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white resize-none">{{ old('message') }}</textarea>

                            @error('message')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-[#7C3AED] text-white font-bold rounded-xl shadow-md hover:bg-[#6D28D9] transition duration-300">

                            <span>Kirim Pesan Sekarang</span>
                            <i class="fa-solid fa-paper-plane"></i>

                        </button>

                    </form>

                </div>

            </div>

            {{-- Peta: dimuat otomatis. loading="lazy" tetap dipakai supaya browser
                 menunda request sampai elemen mendekati viewport (native lazy-load).
                 Tinggi wrapper dibuat responsif via class, iframe ikut mengisi penuh. --}}
            <div
                class="relative rounded-3xl sm:rounded-[2.5rem] overflow-hidden shadow-xl border border-gray-100 h-72 sm:h-96 md:h-[500px]">
                <div
                    class="absolute top-0 left-0 right-0 bg-gradient-to-b from-white/90 to-transparent p-4 sm:p-6 md:p-8 z-10 pointer-events-none">
                    <h3
                        class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 text-center flex items-center justify-center gap-2 sm:gap-3">
                        <i class="fa-solid fa-map-location-dot text-[#7C3AED]"></i> Temukan Lokasi Kami
                    </h3>
                </div>

                <iframe src="https://maps.google.com/maps?q=-7.801948,110.326779&z=15&output=embed" class="w-full h-full"
                    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </div>
@endsection
