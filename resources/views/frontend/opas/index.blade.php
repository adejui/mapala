@extends('frontend.layouts.app')

@section('content')
    <div class="flex justify-end">
        @if (session('success'))
            <x-alert-success title="Berhasil!" :message="session('success')" />
        @endif
    </div>


    <div class="bg-white min-h-screen pt-32 pb-20 px-6 md:px-16">

        <div class="bg-gray-50 min-h-screen pt-0 pb-20 px-6 md:px-16">
            <div class="max-w-7xl mx-auto">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
                        <p class="text-gray-500 mt-1 text-sm">Kelola informasi akun anda.</p>
                    </div>
                    <nav class="flex text-sm font-medium text-gray-500">
                        <a href="{{ route('frontend.home') }}" class="hover:text-[#7C3AED] transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <span class="text-[#7C3AED]">Profil Saya</span>
                    </nav>
                </div>

                <a href="{{ session('profile_back_url') ?? route('frontend.home') }}"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full bg-white border-2 hover:border-2 hover:border-purple-600
           text-purple-600 text-lg font-medium shadow-sm 
           hover:shadow-md transition duration-300">

                    <img src="{{ asset('assets/images/icons/arrow-left-1.svg') }}" alt="Back Icon" class="w-4 h-4">

                    <span class="text-sm">back</span>
                </a>

                {{-- <a href="{{ session('profile_back_url') ?? route('frontend.home') }}" class="text-black">
                    Back
                </a> --}}

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-2">

                    {{-- FOTO PROFIL (KIRI) --}}
                    <div class="lg:col-span-1 space-y-8">
                        <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">

                            <div class=" rounded-xl p-6 flex flex-col items-center">

                                @php
                                    $opa = auth('opa')->user();
                                @endphp

                                <!-- Foto Profil + Action -->
                                <div class="relative w-fit">

                                    <!-- Foto Profil -->
                                    <div class="w-fit flex justify-center">
                                        <img src="{{ $opa && $opa->photo ? asset('storage/' . $opa->photo) : asset('storage/imgUsers/default-image.png') }}"
                                            alt="Foto Profil" class="h-44 w-44 object-cover rounded-full border-2">
                                    </div>

                                    <!-- Tombol Icon (pojok kanan bawah) -->
                                    <div class="absolute bottom-0 right-0 flex gap-0.5">

                                        <!-- GANTI FOTO -->
                                        <form action="{{ route('frontend.opa.update-photo') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <label for="photo-input"
                                                class="bg-[#7753AF] text-white p-2 border-2 border-white rounded-full cursor-pointer flex items-center justify-center hover:bg-[#6D28D9] transition shadow-md"
                                                title="Ganti Foto">

                                                <i class="fa-regular fa-pen-to-square text-md"></i>

                                            </label>

                                            <input type="file" id="photo-input" name="photo" class="hidden"
                                                accept="image/*" onchange="this.form.submit()">
                                        </form>

                                        <!-- HAPUS FOTO -->
                                        <form action="{{ route('frontend.opa.delete-photo') }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="bg-white text-[#7753AF] p-2 border-2 border-[#7753AF] rounded-full flex items-center justify-center hover:bg-purple-50 transition shadow-md"
                                                title="Hapus Foto">

                                                <i class="fa-regular fa-trash-can text-sm"></i>

                                            </button>
                                        </form>

                                    </div>

                                </div>



                                <div class="text-black font-bold mt-2">TA.XI.23.075</div>

                                <div
                                    class="flex px-4 pt-0.5 pb-1.5 mt-2 mb-10 items-center justify-center text-sm text-gray-700 border border-gray-300 rounded-full bg-gray-100">
                                    Eksternal
                                </div>


                            </div>

                        </div>
                    </div>

                    {{-- FORM (KANAN) --}}
                    <div class="lg:col-span-2 space-y-8">


                        <form action="{{ route('frontend.opa.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf



                            <div class="lg:col-span-2 space-y-8">

                                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-bold text-gray-900">
                                            Detail Informasi
                                        </h3>

                                        <button type="submit"
                                            class="text-sm text-white px-5 py-2 border-2 border-[#7753AF] bg-[#7753AF] rounded-xl flex items-center justify-center hover:bg-[#6D28D9] transition">
                                            Update
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        {{-- NAMA --}}
                                        <div class="md:col-span-2">
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                Nama Lengkap <span class="text-red-500">*</span>
                                            </label>

                                            <input type="text" name="name"
                                                value="{{ old('name', auth('opa')->user()->name ?? '') }}"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
            focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
            transition-all text-sm font-medium text-gray-900 placeholder-gray-400
            @error('name') border-red-500 ring-1 ring-red-500
            @else border-gray-200 @enderror"
                                                placeholder="Masukkan nama lengkap sesuai KTP...">

                                            @error('name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- KAMPUS --}}
                                        @if ('opa')
                                            <div>
                                                <label
                                                    class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                    Kampus Asal <span class="text-red-500">*</span>
                                                </label>

                                                <input type="text" name="campus_name"
                                                    value="{{ old('campus_name', auth('opa')->user()->campus_name ?? '') }}"
                                                    class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
            focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
            transition-all text-sm font-medium text-gray-900 placeholder-gray-400
            @error('campus_name') border-red-500 ring-1 ring-red-500
            @else border-gray-200 @enderror"
                                                    placeholder="Contoh: UBSI Yogyakarta">

                                                @error('campus_name')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endif


                                        {{-- ORGANISASI --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                Organisasi <span class="text-red-500">*</span>
                                            </label>

                                            <input type="text" name="organization_name"
                                                value="{{ old('organization_name', auth('opa')->user()->organization_name ?? '') }}"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
            focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
            transition-all text-sm font-medium text-gray-900 placeholder-gray-400
            @error('organization_name') border-red-500 ring-1 ring-red-500
            @else border-gray-200 @enderror"
                                                placeholder="Mapala / UKM / Umum">

                                            @error('organization_name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- PHONE --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                No WhatsApp <span class="text-red-500">*</span>
                                            </label>

                                            <input type="text" name="phone_number"
                                                value="{{ old('phone_number', auth('opa')->user()->phone_number ?? '') }}"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
            focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
            transition-all text-sm font-medium text-gray-900 placeholder-gray-400
            @error('phone_number') border-red-500 ring-1 ring-red-500
            @else border-gray-200 @enderror"
                                                placeholder="08xxxxxxxxxx">

                                            @error('phone_number')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- EMAIL --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                Email <span class="text-red-500">*</span>
                                            </label>

                                            <input type="email" name="email"
                                                value="{{ auth('opa')->user()->email ?? '' }}"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
            focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
            transition-all text-sm font-medium text-gray-900 placeholder-gray-400 border-gray-200"
                                                readonly>

                                        </div>

                                    </div>


                                </div>




                            </div>

                        </form>

                    </div>

                </div>



            </div>






        </div>






    </div>
    </div>


    </div>
@endsection
