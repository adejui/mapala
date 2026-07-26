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



                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- FOTO PROFIL (KIRI) --}}
                    <div class="lg:col-span-1 space-y-8">
                        <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">

                            <div class=" rounded-xl p-6 flex flex-col items-center">

                                @php
                                    $opa = auth('opa')->user();
                                @endphp

                                {{-- <!-- Foto Profil -->
                                <div class="w-fit flex justify-center bg-amber-300">
                                    <img src="{{ $opa && $opa->photo ? asset('storage/' . $opa->photo) : asset('storage/imgUsers/default-image.png') }}"
                                        alt="Foto Profil" class="h-full w-44 object-cover rounded-full border-2">
                                </div> --}}


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



                                <div class="text-black font-bold mt-2">{{ auth('web')->user()->nrp }}</div>

                                <div
                                    class="flex px-4 pt-0.5 pb-1.5 mt-2 items-center justify-center text-sm text-gray-700 border border-gray-300 rounded-full bg-gray-100">
                                    {{ auth('web')->user()->role == 'member'
                                        ? 'Anggota'
                                        : (auth('web')->user()->role == 'logistics'
                                            ? 'Logistik'
                                            : (auth('web')->user()->role == 'admin'
                                                ? 'Admin'
                                                : '-')) }}
                                </div>


                                <div class="w-full h-0.5 bg-gray-200 mt-4"></div>

                                <div class="w-full mt-3">
                                    <div class="grid grid-cols-[100px_1fr] text-black text-sm gap-y-1">
                                        <div>Program Studi</div>
                                        <div>: {{ auth('web')->user()->major }}</div>

                                        <div>Angkatan</div>
                                        <div>: {{ auth('web')->user()->generation }}</div>

                                        <div>Tahun</div>
                                        <div>: {{ auth('web')->user()->batch }}</div>
                                    </div>
                                </div>



                                <!-- Tombol Ganti & Hapus (Icon Only) -->
                                {{-- <div class="flex w-full gap-x-3 mt-4">

                                    <!-- GANTI FOTO -->
                                    <form action="{{ route('frontend.opa.update-photo') }}" method="POST"
                                        enctype="multipart/form-data" class="w-full">
                                        @csrf

                                        <label for="photo-input"
                                            class="text-[#7753AF] p-2.5 border-2 border-[#7753AF] w-fit rounded-xl cursor-pointer flex items-center justify-center hover:bg-[#6D28D9] transition"
                                            title="Ganti Foto">

                                            <i class="fa-regular fa-pen-to-square text-base"></i>

                                        </label>

                                        <input type="file" id="photo-input" name="photo" class="hidden"
                                            accept="image/*" onchange="this.form.submit()">
                                    </form>

                                    <!-- HAPUS FOTO -->
                                    <form action="{{ route('frontend.opa.delete-photo') }}" method="POST" class="w-full"
                                        onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="text-[#7753AF] p-2.5 border-2 border-[#7753AF] w-fit rounded-xl flex items-center justify-center hover:bg-purple-50 transition"
                                            title="Hapus Foto">

                                            <i class="fa-regular fa-trash-can text-base"></i>

                                        </button>
                                    </form>

                                </div> --}}




                            </div>

                        </div>
                    </div>

                    {{-- FORM (KANAN) --}}
                    <div class="lg:col-span-2 space-y-8">


                        <form action="{{ route('frontend.opa.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                                    <h3 class="text-lg font-bold text-gray-900 mb-6">Detail Informasi</h3> --}}

                            <div class="lg:col-span-2 space-y-8">

                                <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
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

                                            <input type="text" name="full_name"
                                                value="{{ old('full_name', optional(auth('web')->user())->full_name) }}"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
        focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
        transition-all text-sm font-medium text-gray-900 placeholder-gray-400
        @error('full_name') border-red-500 ring-1 ring-red-500
        @else border-gray-200 @enderror"
                                                placeholder="Masukkan nama lengkap sesuai KTP...">

                                            @error('full_name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                Jenis kelamin
                                            </label>

                                            <input type="text" readonly
                                                value="{{ optional(auth()->user())->gender == 'male'
                                                    ? 'Laki-laki'
                                                    : (optional(auth()->user())->gender == 'female'
                                                        ? 'Perempuan'
                                                        : '-') }}"
                                                class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-3.5
        text-sm font-medium text-gray-500">
                                        </div>


                                        {{-- TANGGAL LAHIR --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                Tanggal Lahir <span class="text-red-500">*</span>
                                            </label>

                                            <input type="text" name="birth_date"
                                                value="{{ old(
                                                    'birth_date',
                                                    optional(auth('opa')->user())->birth_date
                                                        ? \Carbon\Carbon::parse(auth('opa')->user()->birth_date)->translatedFormat('d F Y')
                                                        : '',
                                                ) }}"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
        focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
        transition-all text-sm font-medium text-gray-900 placeholder-gray-400
        @error('birth_date') border-red-500 ring-1 ring-red-500
        @else border-gray-200 @enderror"
                                                readonly placeholder="23 Januari 2026">

                                            @error('birth_date')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- PHONE --}}
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                No Telp <span class="text-red-500">*</span>
                                            </label>

                                            <input type="text" name="phone_number"
                                                value="{{ old('phone_number', optional(auth('web')->user())->phone_number) }}"
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
                                                value="{{ old('email', optional(auth('web')->user())->email) }}"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
            focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
            transition-all text-sm font-medium text-gray-900 placeholder-gray-400 border-gray-200"
                                                readonly>

                                        </div>


                                    </div>



                                </div>







                            </div>









                            <div class="lg:col-span-2 space-y-8 mt-5">

                                <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-bold text-gray-900">
                                            Update Password
                                        </h3>

                                        <button type="submit"
                                            class="text-sm text-white px-5 py-2 border-2 border-[#7753AF] bg-[#7753AF] rounded-xl flex items-center justify-center hover:bg-[#6D28D9] transition">
                                            Update
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                                        <!-- PASSWORD LAMA -->
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                Password Lama <span class="text-red-500">*</span>
                                            </label>

                                            <input type="password" name="current_password"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
        focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
        transition-all text-sm font-medium text-gray-900 placeholder-gray-400
        @error('current_password') border-red-500 ring-1 ring-red-500
        @else border-gray-200 @enderror"
                                                placeholder="Masukkan password lama">

                                            @error('current_password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- PASSWORD BARU -->
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                                Password Baru <span class="text-red-500">*</span>
                                            </label>

                                            <input type="password" name="new_password"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
        focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
        transition-all text-sm font-medium text-gray-900 placeholder-gray-400
        @error('new_password') border-red-500 ring-1 ring-red-500
        @else border-gray-200 @enderror"
                                                placeholder="Masukkan password baru">

                                            @error('new_password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>



                                    </div>


                                </div>



                            </div>


                            {{-- </div> --}}
                        </form>

                    </div>

                </div>



            </div>






        </div>






    </div>
    </div>


    </div>
@endsection
