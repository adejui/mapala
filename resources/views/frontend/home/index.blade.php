@extends('frontend.layouts.app')

@section('content')
    @if ($showCompleteProfileModal)
        <div id="completeProfileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4">

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md px-8 py-5 relative">

                <!-- Tombol Close -->
                <button type="button"
                    class="closeCompleteProfileModal absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="text-center mt-2">

                    <div class="flex items-center justify-center mb-3">
                        <div class="w-22 h-22 rounded-full bg-purple-100 flex items-center justify-center">

                            <div class="w-12 h-12 rounded-full bg-purple-600 flex items-center justify-center shadow-md">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-3.314 0-6 2.686-6 6h12c0-3.314-2.686-6-6-6z" />
                                </svg>

                            </div>

                        </div>
                    </div>


                    <h2 class="text-tarantulaPurple text-xl font-bold dark:text-white">
                        Lengkapi Profile
                    </h2>

                    <div class="text-sm text-gray-500 dark:text-gray-300 mt-2 leading-relaxed">

                        <p>Lengkapi profilmu dulu agar bisa meminjam barang.</p>
                        <p>Hanya butuh <span class="text-tarantulaPurple font-semibold">1 menit</span> untuk melengkapi</p>
                        <p>data
                            yang
                            diperlukan.</p>
                    </div>

                    <div class="mt-6">

                        @if (auth()->guard('web')->check())
                            <a href="{{ route('frontend.user.profile') }}"
                                class="inline-flex items-center justify-center w-full px-6 py-2 text-md text-white font-light rounded-xl bg-purple-600 hover:bg-purple-700 transition duration-300 shadow-md">

                                Ke Halaman Profile
                                <span class="ml-2">→</span>
                            </a>
                        @elseif(auth()->guard('opa')->check())
                            <a href="{{ route('frontend.opa.profile') }}"
                                class="inline-flex items-center justify-center w-full px-6 py-2 text-white font-light rounded-xl bg-purple-600 hover:bg-purple-700 transition duration-300 shadow-md">

                                Ke Halaman Profile
                                <span class="ml-2">→</span>
                            </a>
                        @endif

                        <div class="text-center mt-2">
                            <button type="button"
                                class="closeCompleteProfileModal text-gray-700 font-light hover:text-gray-600 transition duration-300">
                                Nanti Saja
                            </button>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const modal = document.getElementById("completeProfileModal");

                // ambil SEMUA tombol dengan class ini
                const closeButtons = document.querySelectorAll(".closeCompleteProfileModal");

                // looping semua tombol
                closeButtons.forEach(button => {

                    button.addEventListener("click", function() {

                        modal.classList.add("hidden");

                    });

                });

            });
        </script>
    @endif














    <div id="hero-section" class="relative h-[590px] w-full overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('frontend/images/hero-section.jpeg') }}" alt="Background"
                class="w-full h-full object-cover grayscale brightness-50" />
        </div>
        <div class="absolute inset-0 z-0 bg-black/40"></div>
        <main class="absolute inset-0 z-10 flex flex-col justify-center items-center text-center px-4">
            <h3 data-aos="fade-up" class="text-xl md:text-2xl font-semibold mb-2 text-gray-200 drop-shadow-md">Welcome to
            </h3>
            <h1 data-aos="fade-up" data-aos-delay="200" class="text-5xl md:text-7xl font-bold mb-4 drop-shadow-lg">
                Tarantula <span class="text-tarantulaPurple">Adventure</span>
            </h1>
            <p data-aos="fade-up" data-aos-delay="400" class="text-base md:text-lg text-gray-300 max-w-2xl drop-shadow-md">
                Mahasiswa Pencinta Alam Universitas Bina Sarana Informatika
            </p>
        </main>
    </div>

    <!-- sejarah -->
    <section class="bg-gray-100 py-16 px-6 md:px-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-2 items-start">
                <div class="font-bold text-3xl md:text-4xl leading-tight">
                    <h2 class="text-gray-900">Sejarah</h2>
                    <h2 class="text-[#7C3AED] mt-1">Tarantula Adventure</h2>
                </div>

                <div>
                    <p class="text-gray-500 text-base md:text-lg leading-relaxed mb-8 text-justify">
                        Tarantula Adventure berdiri sebagai organisasi Mahasiswa Pecinta
                        Alam di UBSI Yogyakarta yang berawal dari sekelompok mahasiswa
                        yang memiliki minat kuat terhadap kegiatan alam bebas dan
                        pelestarian lingkungan.
                    </p>

                    <a href="{{ route('frontend.about') }}"
                        class="inline-block bg-[#7c56b5] text-white font-medium px-6 py-3 rounded-lg hover:bg-purple-800 transition shadow-md">
                        Tentang kami
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- sejarah end -->

    <!-- jadwal -->
    <section class="py-16 px-6 md:px-20">
        <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="w-full md:w-3/4">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    Jadwal Kegiatan Yang Akan Datang
                </h1>
                <p class="text-gray-500 text-sm md:text-base">
                    Tetap terhubung dengan kegiatan petualangan dan pengembangan anggota
                    Tarantula Adventure.
                </p>
            </div>

            <div class="flex-shrink-0">
                <a href="{{ route('frontend.kegiatan') }}"
                    class="bg-[#7753AF] hover:bg-[#5e3d8e] text-white font-medium px-6 py-3 rounded-xl transition shadow-md whitespace-nowrap">
                    Lihat Semua
                </a>
            </div>
        </div>

        <div class="w-full lg:full space-y-6">

            @forelse ($activities as $activity)
                <div data-aos="fade-left" data-aos-delay="{{ $loop->iteration * 100 }}"
                    class="border border-gray-200 rounded-2xl p-4 hover:shadow-lg transition duration-300 bg-white">

                    <div class="flex justify-between items-start mb-4">

                        <div class="flex flex-col sm:flex-row gap-3">
                            <div
                                class="inline-flex items-center bg-gray-50 border border-gray-200 rounded-full px-3 py-1.5 shadow-sm text-xs sm:text-sm">

                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-gray-500"></i>
                                    <span class="font-medium text-gray-700">
                                        {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="w-px h-4 bg-gray-300 mx-2"></div>

                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-700">
                                        {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex -space-x-2">

                            @foreach ($activity->members->take(3) as $member)
                                <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden bg-gray-200"
                                    title="{{ $member->full_name }}">
                                    <img src="{{ $member->photo ? asset('storage/' . $member->photo) : asset('frontend/images/user-default.jpeg') }}"
                                        alt="{{ $member->name }}"
                                        class="w-full h-full object-cover rounded-full border-2 border-gray">
                                </div>
                            @endforeach

                            @if ($activity->members->count() > 3)
                                <div
                                    class="w-8 h-8 rounded-full bg-[#7753AF] text-white text-[10px] flex items-center justify-center border-2 border-white font-bold">
                                    +{{ $activity->members->count() - 3 }}
                                </div>
                            @endif

                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug">
                        {{ $activity->title }}
                    </h3>

                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-2">
                        {{ Str::limit($activity->description, 120) }}
                    </p>

                    <a href="{{ route('frontend.kegiatan.show', $activity->id) }}"
                        class="inline-flex items-center gap-2 text-[#7753AF] font-semibold text-sm hover:underline">
                        Lihat Detail Kegiatan <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>
            @empty
                <div class="p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500 font-medium">Belum ada jadwal kegiatan terbaru.</p>
                </div>
            @endforelse

        </div>
    </section>
    <!-- jadwal end -->

    <!-- inventarsi -->
    <section class="px-6 md:px-20">
        <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="w-full md:w-3/4">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    Inventaris Peralatan
                </h1>
                <p class="text-gray-500 text-sm md:text-base">
                    Pastikan setiap item siap untuk ekspidisi berikutnya
                </p>
            </div>

            <div class="flex-shrink-0">
                <a href="{{ route('frontend.inventory') }}"
                    class="bg-[#7753AF] hover:bg-[#5e3d8e] text-white font-medium px-6 py-3 rounded-xl transition shadow-md whitespace-nowrap">
                    Lihat Semua
                </a>
            </div>
        </div>

        {{-- card --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-6">

            @forelse($inventoryItems as $item)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}"
                    class="w-full bg-white border-2 border-gray-200 rounded-3xl flex flex-col overflow-hidden h-full hover:shadow-xl transition-shadow duration-300">

                    <div class="relative w-full h-56 bg-gray-100 flex items-center justify-center overflow-hidden">

                        <span
                            class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-gray-700 text-[10px] font-bold px-3 py-1 rounded-full border border-gray-200 uppercase tracking-wide z-10 shadow-sm">
                            {{ $item->category->name ?? 'Umum' }}
                        </span>

                        <img src="{{ $item->photo ? asset('storage/' . $item->photo) : asset('frontend/images/tas.jpg') }}"
                            alt="{{ $item->name }}"
                            class="w-full h-full object-contain p-6 mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                    </div>

                    <div
                        class="p-5 flex justify-between items-end flex-grow border-t border-gray-100 bg-white relative z-20">
                        <div>
                            <h3 class="text-gray-900 font-semibold text-base leading-tight mb-1 line-clamp-2"
                                title="{{ $item->name }}">
                                {{ $item->name }}
                            </h3>

                            <p class="text-gray-500 text-xs font-semibold tracking-wider mt-1">
                                {{ $item->quantity ?? ($item->stock ?? 0) }} Unit
                            </p>
                        </div>

                        <a href="{{ route('frontend.inventory.show', $item->id) }}">
                            <button
                                class="w-12 h-12 bg-[#7753AF] rounded-xl flex items-center justify-center text-white hover:bg-[#5e3d8e] hover:scale-110 transition-all duration-300 shadow-md flex-shrink-0 group/btn">

                                <i
                                    class="fa-solid fa-arrow-right -rotate-45 group-hover/btn:rotate-0 transition-transform duration-300">
                                </i>

                            </button>
                        </a>

                        {{-- <button
                            class="w-12 h-12 bg-[#7753AF] rounded-xl flex items-center justify-center text-white hover:bg-[#5e3d8e] hover:scale-110 transition-all duration-300 shadow-md flex-shrink-0 group/btn">
                            <i
                                class="fa-solid fa-arrow-right -rotate-45 group-hover/btn:rotate-0 transition-transform duration-300"></i>
                        </button> --}}
                    </div>

                </div>

            @empty
                <div class="col-span-full py-12 text-center border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50">
                    <div class="inline-block p-4 bg-white rounded-full mb-3 shadow-sm">
                        <i class="fa-solid fa-box-open text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-gray-900 font-semibold">Belum ada barang</h3>
                    <p class="text-gray-500 text-sm mt-1">Silakan cek kembali nanti.</p>
                </div>
            @endforelse

        </div>
    </section>
    <!-- inventarsi end-->

    <!-- artikel -->
    <section class="py-20 px-6 md:px-20">
        <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="w-full md:w-3/4">
                <h1 data-aos="zoom-in-right" class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    Artikel Terbaru
                </h1>
                <p data-aos="zoom-in-left" class="text-gray-500 text-sm md:text-base">
                    Temukan cerita terbaru, tips, dan pengalaman petualangan.
                </p>
            </div>

            <div class="flex-shrink-0">
                <a href="{{ route('frontend.artikel') }}"
                    class="bg-[#7753AF] hover:bg-[#5e3d8e] text-white font-medium px-6 py-3 rounded-xl transition shadow-md whitespace-nowrap">
                    Lihat Semua
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach ($articles as $article)
                <div
                    class="relative h-[300px] rounded-2xl overflow-hidden group cursor-pointer shadow-md hover:shadow-xl transition-all duration-300">

                    <!-- Tanggal -->
                    <div
                        class="absolute top-4 left-4 z-20 bg-white text-gray-800 text-xs font-medium px-3 py-1.5 rounded-full flex items-center gap-2 shadow-sm">
                        <i class="fa-regular fa-calendar"></i>
                        <span>
                            {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('l, d F Y') }}
                        </span>
                    </div>

                    <!-- Gambar -->
                    <img src="{{ $article->file_path
                        ? asset('storage/' . $article->file_path)
                        : asset('assets/images/articles/default-image.png') }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                    <!-- Overlay -->
                    <div
                        class="absolute bottom-0 left-0 w-full h-[40%] z-10 flex flex-col justify-end p-6 bg-gradient-to-t from-black/90 via-black/60 to-transparent backdrop-blur-md">

                        <!-- Judul -->
                        <h3 class="text-white text-xl font-bold leading-tight mb-3 drop-shadow-md">
                            {{ $article->title }}
                        </h3>

                        <!-- Link -->
                        <a href="{{ route('frontend.artikel.show', $article->slug) }}"
                            class="inline-flex items-center text-white text-sm font-semibold hover:text-purple-300 transition-colors group/btn">
                            Read More
                            <i
                                class="fa-solid fa-arrow-right ml-2 text-xs transform transition-transform group-hover/btn:translate-x-1"></i>
                        </a>

                    </div>
                </div>
            @endforeach

        </div>

    </section>
    <!-- artikel end-->
@endsection
