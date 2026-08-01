@extends('frontend.layouts.app')

@section('content')
    <div class="bg-white min-h-screen pt-24 md:pt-32 pb-0 w-full">

        <div class="w-full py-2">

            <div class="w-full">

                <div
                    class="flex px-6 md:px-12 lg:px-24 xl:px-32 flex-col mb-10 md:mb-14 sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Tentang Kami</h1>
                        <p class="text-gray-500 mt-1 text-sm">Sejarah singkat organisasi kami</p>
                    </div>

                    <nav class="flex flex-wrap text-sm font-medium text-gray-500">
                        <a href="{{ route('frontend.home') }}" class="hover:text-[#7C3AED] transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-[#7C3AED]">Tentang kami</span>
                    </nav>
                </div>



                <div class="grid px-6 md:px-12 lg:px-24 xl:px-32 grid-cols-1 lg:grid-cols-2 gap-8 mb-4 items-start">


                    <div>
                        <div class="flex-col text-gray-900">
                            <h3 class="text-3xl md:text-4xl lg:text-5xl font-bold">Sejarah</h3>
                            <h3 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2 text-[#7C3AED]">Tarantula Adventure
                            </h3>
                            <div class="font-light text-sm md:text-md mt-5 text-justify">
                                Pembentukan organisasi penggiat alam ini berawal dari gagasan sejumlah mahasiswa BSI
                                Yogyakarta, khususnya dari jurusan Manajemen Informatika, yang menginginkan adanya wadah
                                untuk menampung serta menyalurkan minat dan bakat di bidang kegiatan alam bebas dalam
                                lingkup universitas. Berdasarkan semangat tersebut, lahirlah organisasi TARANTULA ADVENTURE
                                yang resmi didirikan pada 16 Desember 2011 sebagai sarana pengembangan diri, kebersamaan,
                                dan kepedulian terhadap alam.
                            </div>
                        </div>
                    </div>


                    <div>

                        <img src="{{ asset('assets/images/articles/default-image.png') }}"
                            class="w-full rounded-2xl h-56 md:h-72 lg:max-h-80 object-cover transition-transform duration-500 group-hover:scale-110">

                    </div>


                </div>

                <div
                    class="grid px-6 md:px-12 lg:px-24 xl:px-32 items-center bg-gray-100 w-full py-10 md:py-8 grid-cols-1 lg:grid-cols-2 gap-8">

                    <div>
                        <div class="text-left lg:text-center flex-col text-gray-900">
                            <h3 class="text-3xl md:text-4xl lg:text-5xl font-bold">Visi</h3>
                        </div>
                    </div>

                    <div>
                        <div class="flex-col text-gray-900">
                            <div class="font-light text-sm md:text-md mt-5 lg:mt-0 text-justify">
                                Pembentukan organisasi penggiat alam ini berawal dari gagasan sejumlah mahasiswa BSI
                                Yogyakarta, khususnya dari jurusan Manajemen Informatika, yang menginginkan adanya wadah
                                untuk menampung serta menyalurkan minat dan bakat di bidang kegiatan alam bebas dalam
                                lingkup universitas. Berdasarkan semangat tersebut, lahirlah organisasi TARANTULA ADVENTURE
                                yang resmi didirikan pada 16 Desember 2011 sebagai sarana pengembangan diri, kebersamaan,
                                dan kepedulian terhadap alam.
                            </div>
                        </div>
                    </div>

                </div>


                <div class="w-full py-10">

                    <!-- JUDUL -->
                    <div class="flex justify-center items-center text-gray-900 mb-5 px-6">
                        <h3 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center">Misi</h3>
                    </div>

                    <!-- GRID MISI -->
                    <div
                        class="grid px-6 md:px-12 lg:px-24 xl:px-32 py-5
                w-full grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 text-white">

                        <div class="w-full">
                            <div class="flex text-gray-900 gap-4">
                                <h3 class="text-3xl md:text-4xl font-bold shrink-0">01</h3>
                                <div class="font-light text-sm md:text-md">
                                    Mempererat tali persaudaraan antar sesama anggota maupun sesama kelompok pecinta alam.
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="flex text-gray-900 gap-4">
                                <h3 class="text-3xl md:text-4xl font-bold shrink-0">02</h3>
                                <div class="font-light text-sm md:text-md">
                                    Menjalin hubungan kerjasama yang dinamis serta koordinasi diantara sesama pecinta alam
                                    dan
                                    masyarakat.
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="flex text-gray-900 gap-4">
                                <h3 class="text-3xl md:text-4xl font-bold shrink-0">03</h3>
                                <div class="font-light text-sm md:text-md">
                                    Meningkatkan peran aktif dalam menangani masalah lingkungan serta menjaga citra positif
                                    pecinta alam, khususnya di Yogyakarta.
                                </div>
                            </div>
                        </div>

                    </div>

                </div>




                <div class="w-full bg-gray-100 py-12 md:py-16 px-6 md:px-12 lg:px-24 xl:px-32">

                    <div class="mb-8 md:mb-10">
                        <h3 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900">Galeri</h3>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">

                        <div class="group overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/articles/default-image.png') }}"
                                class="w-full h-36 sm:h-48 md:h-60 object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="group overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/articles/default-image.png') }}"
                                class="w-full h-36 sm:h-48 md:h-60 object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="group overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/articles/default-image.png') }}"
                                class="w-full h-36 sm:h-48 md:h-60 object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="group overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/articles/default-image.png') }}"
                                class="w-full h-36 sm:h-48 md:h-60 object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <div class="group overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/articles/default-image.png') }}"
                                class="w-full h-36 sm:h-48 md:h-60 object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="group overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/articles/default-image.png') }}"
                                class="w-full h-36 sm:h-48 md:h-60 object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="group overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/articles/default-image.png') }}"
                                class="w-full h-36 sm:h-48 md:h-60 object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="group overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/articles/default-image.png') }}"
                                class="w-full h-36 sm:h-48 md:h-60 object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                    </div>

                </div>




            </div>
        </div>
    </div>
