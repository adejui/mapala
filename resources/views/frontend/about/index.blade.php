@extends('frontend.layouts.app')

@section('content')
    <div class="bg-white min-h-screen pt-24 md:pt-32">

        {{-- Header --}}
        <section class="px-6 md:px-12 lg:px-24 xl:px-32 mb-14">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Tentang Kami
                    </h1>

                    <p class="text-gray-500 mt-1">
                        Sejarah singkat organisasi kami
                    </p>
                </div>

                <nav class="flex text-sm text-gray-500">
                    <a href="{{ route('frontend.home') }}" class="hover:text-[#7C3AED] transition">
                        Home
                    </a>

                    <span class="mx-2">/</span>

                    <span class="text-[#7C3AED]">
                        Tentang Kami
                    </span>
                </nav>

            </div>

        </section>


        {{-- Sejarah --}}
        <section class="px-6 md:px-12 lg:px-24 xl:px-32 mb-16">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div>

                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900">
                        Sejarah
                    </h2>

                    <h2 class="text-4xl lg:text-5xl font-bold text-[#7C3AED] mt-2">
                        Tarantula Adventure
                    </h2>

                    <p class="text-base text-gray-700 leading-relaxed text-justify mt-6">

                        Pembentukan organisasi penggiat alam ini berawal dari gagasan sejumlah mahasiswa
                        BSI Yogyakarta, khususnya dari jurusan Manajemen Informatika, yang menginginkan
                        adanya wadah untuk menampung serta menyalurkan minat dan bakat di bidang kegiatan
                        alam bebas dalam lingkup universitas.

                        Berdasarkan semangat tersebut, lahirlah organisasi TARANTULA ADVENTURE yang resmi
                        didirikan pada 16 Desember 2011 sebagai sarana pengembangan diri, kebersamaan,
                        dan kepedulian terhadap alam.

                    </p>

                </div>

                <div>

                    <div class="overflow-hidden rounded-2xl shadow-lg">

                        <img src="{{ asset('frontend/images/hero-section.jpeg') }}" alt="Sejarah Tarantula Adventure"
                            class="w-full h-64 md:h-80 lg:h-96 object-cover">

                    </div>

                </div>

            </div>

        </section>


        {{-- VISI --}}
        <section class="bg-gray-100 py-14">

            <div class="px-6 md:px-12 lg:px-24 xl:px-32">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                    <div>

                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 lg:text-center">
                            Visi
                        </h2>

                    </div>

                    <div>

                        <p class="text-base text-gray-700 leading-relaxed text-justify">

                            Pembentukan organisasi penggiat alam ini berawal dari gagasan sejumlah mahasiswa
                            BSI Yogyakarta, khususnya dari jurusan Manajemen Informatika, yang menginginkan
                            adanya wadah untuk menampung serta menyalurkan minat dan bakat di bidang
                            kegiatan alam bebas dalam lingkup universitas.

                            Berdasarkan semangat tersebut, lahirlah organisasi TARANTULA ADVENTURE yang
                            resmi didirikan pada 16 Desember 2011 sebagai sarana pengembangan diri,
                            kebersamaan, dan kepedulian terhadap alam.

                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- MISI --}}
        <section class="py-16">

            <div class="px-6 md:px-12 lg:px-24 xl:px-32">

                <h2 class="text-center text-4xl lg:text-5xl font-bold text-gray-900 mb-12">
                    Misi
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

                    <div class="flex gap-4">

                        <h3 class="text-4xl font-bold text-gray-900">
                            01
                        </h3>

                        <p class="text-base text-gray-700 leading-relaxed">

                            Mempererat tali persaudaraan antar sesama anggota maupun sesama kelompok
                            pecinta alam.

                        </p>

                    </div>

                    <div class="flex gap-4">

                        <h3 class="text-4xl font-bold text-gray-900">
                            02
                        </h3>

                        <p class="text-base text-gray-700 leading-relaxed">

                            Menjalin hubungan kerja sama yang dinamis serta koordinasi di antara sesama
                            pecinta alam dan masyarakat.

                        </p>

                    </div>

                    <div class="flex gap-4">

                        <h3 class="text-4xl font-bold text-gray-900">
                            03
                        </h3>

                        <p class="text-base text-gray-700 leading-relaxed">

                            Meningkatkan peran aktif dalam menangani masalah lingkungan serta menjaga
                            citra positif pecinta alam, khususnya di Yogyakarta.

                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- GALERI --}}
        <section class="bg-gray-100 py-16">

            <div class="px-6 md:px-12 lg:px-24 xl:px-32">

                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-10">
                    Galeri
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">

                    @foreach (['artikel-1.jpeg', 'artikel-6.jpeg', 'artikel-3.jpeg', 'artikel-4.jpeg', 'artikel-5.jpeg', 'artikel-2.jpeg'] as $image)
                        <div class="overflow-hidden rounded-2xl shadow">

                            <img src="{{ asset('frontend/images/' . $image) }}" alt="Galeri"
                                class="w-full h-44 md:h-64 object-cover transition duration-500 hover:scale-110">

                        </div>
                    @endforeach

                </div>

            </div>

        </section>

    </div>
@endsection
