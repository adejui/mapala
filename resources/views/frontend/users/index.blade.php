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

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5 gap-4">
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




                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">


                    <div>
                        <div class="lg:col-span-1 space-y-8">
                            <div class="bg-white rounded-2xl border border-gray-300 px-6 py-4 mb-4">
                                <div class="flex items-center">

                                    @php
                                        $opa = auth('opa')->user();
                                        $user = auth('web')->user();
                                    @endphp

                                    <!-- KIRI -->
                                    <div class="flex items-center gap-4 mr-20">

                                        <!-- FOTO -->
                                        <div class="relative">
                                            <img src="{{ $user && $user->photo ? asset('storage/' . $user->photo) : asset('frontend/images/user-default.jpeg') }}"
                                                class="w-20 h-20 rounded-full object-cover bg-gray-200">

                                            <!-- ICON -->
                                            <div class="absolute bottom-0 right-0 flex">
                                                <form action="{{ route('frontend.user.update-photo') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <label for="photo-input"
                                                        class="bg-[#7753AF] text-white px-1.5 py-1 rounded-full cursor-pointer text-sm border border-white">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </label>
                                                    <input type="file" id="photo-input" name="photo" class="hidden"
                                                        onchange="this.form.submit()">
                                                </form>

                                                <form action="{{ route('frontend.user.delete-photo') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="bg-white text-[#7753AF] px-1.5 py-1 rounded-full text-sm border border-[#7753AF] -ml-1">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- TEXT -->
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $user->nrp }}</div>

                                            <div
                                                class="mt-1 text-sm px-3 py-1 rounded-full bg-gray-100 border text-gray-600 inline-block">
                                                {{ $user->role == 'member'
                                                    ? 'Anggota'
                                                    : ($user->role == 'logistics'
                                                        ? 'Logistik'
                                                        : ($user->role == 'admin'
                                                            ? 'Admin'
                                                            : '-')) }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- GARIS -->
                                    <div class="h-16 w-0.5 bg-gray-300 mx-6"></div>

                                    <!-- KANAN -->
                                    <div class="text-sm text-gray-700 space-y-2">
                                        <div>
                                            <div class="text-sm text-gray-500">Program studi</div>
                                            <div class="font-medium text-gray-800">{{ $user->major }}</div>
                                        </div>

                                        <div>
                                            <div class="text-sm text-gray-500">Angkatan</div>
                                            <div class="font-medium text-gray-800">{{ $user->generation }}</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1 space-y-8">


                            <form action="{{ route('frontend.user.profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="lg:col-span-2 space-y-4">

                                    <div class="bg-white rounded-2xl border border-gray-300 px-8 py-5">
                                        <div class="flex items-center justify-between mb-6">
                                            <h3 class="text-lg font-bold text-gray-900">
                                                Detail Informasi
                                            </h3>

                                            <button type="submit"
                                                class="text-sm text-white px-5 py-2 border-2 border-[#7753AF] bg-[#7753AF] rounded-xl flex items-center justify-center hover:bg-[#6D28D9] transition">
                                                Update
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                                            {{-- NAMA --}}
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-bold text-gray-700 tracking-wide mb-2">
                                                    Nama Lengkap
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
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 tracking-wide mb-2">
                                                    Jenis kelamin
                                                </label>

                                                <input type="text" readonly
                                                    value="{{ optional(auth()->user())->gender == 'male'
                                                        ? 'Laki-laki'
                                                        : (optional(auth()->user())->gender == 'female'
                                                            ? 'Perempuan'
                                                            : '-') }}"
                                                    class="w-full border border-gray-200 rounded-xl px-4 py-3.5
        text-sm font-medium text-gray-900 bg-gray-100">
                                            </div>


                                            {{-- TANGGAL LAHIR --}}
                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 tracking-wide mb-2">
                                                    Tanggal Lahir
                                                </label>

                                                <input type="text" name="birth_date"
                                                    value="{{ old(
                                                        'birth_date',
                                                        optional(auth('web')->user())->birth_date
                                                            ? \Carbon\Carbon::parse(optional(auth('web')->user())->birth_date)->translatedFormat('d F Y')
                                                            : '',
                                                    ) }}"
                                                    class="w-full text-gray-900 bg-gray-100 border rounded-xl px-4 py-3.5
        focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
        transition-all text-sm font-medium placeholder-gray-400
        @error('birth_date') border-red-500 ring-1 ring-red-500
        @else border-gray-200 @enderror"
                                                    readonly placeholder="">

                                                @error('birth_date')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- PHONE --}}
                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 tracking-wide mb-2">
                                                    No Telp
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
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- EMAIL --}}
                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 tracking-wide mb-2">
                                                    Email
                                                </label>

                                                <input type="email" name="email"
                                                    value="{{ old('email', optional(auth('web')->user())->email) }}"
                                                    class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
            focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
            transition-all text-sm font-medium text-gray-900 placeholder-gray-400 border-gray-200">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <form action="{{ route('frontend.user.update.password') }}" method="POST">
                                @csrf

                                <div class="bg-white rounded-2xl border border-gray-300 p-8">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-bold text-gray-900">
                                            Update Password
                                        </h3>

                                        <button type="submit"
                                            class="text-sm text-white px-5 py-2 border-2 border-[#7753AF] bg-[#7753AF] rounded-xl hover:bg-[#6D28D9] transition">
                                            Update
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        <!-- PASSWORD LAMA -->
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                                Password Lama
                                            </label>

                                            <input type="password" name="current_password"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
        focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
        transition-all text-sm font-medium text-gray-900 placeholder-gray-400
        @error('full_name') border-red-500 ring-1 ring-red-500
        @else border-gray-200 @enderror"
                                                placeholder="Masukkan password lama">

                                            @error('current_password')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- PASSWORD BARU -->
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                                Password Baru
                                            </label>

                                            <input type="password" name="new_password"
                                                class="w-full bg-gray-50 border rounded-xl px-4 py-3.5
        focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white
        transition-all text-sm font-medium text-gray-900 placeholder-gray-400
        @error('full_name') border-red-500 ring-1 ring-red-500
        @else border-gray-200 @enderror"
                                                placeholder="Masukkan password baru">

                                            @error('new_password')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div>
                        <div class="lg:col-span-2 space-y-8">

                            <div class="bg-white rounded-2xl border border-gray-300 p-8">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-gray-900">
                                        Riwayat Kegiatan yang diikuti
                                    </h3>
                                </div>



                                @forelse ($activity_histories as $activity)
                                    <div
                                        class="group bg-white border border-gray-300 mb-3 rounded-3xl px-6 py-4 hover:shadow-xl hover:shadow-purple-100/50 hover:border-purple-100 transition-all duration-300 relative overflow-hidden">

                                        <div class="flex justify-between items-start mb-4">
                                            <div
                                                class="inline-flex items-center gap-3 bg-gray-50 border border-gray-300 rounded-full px-4 py-1">
                                                <i class="fa-regular fa-calendar text-sm text-[#7753AF]"></i>

                                                <div class="flex items-center text-sm font-semibold text-gray-700">
                                                    <span>{{ \Carbon\Carbon::parse($activity->activity->start_date)->format('d M Y') }}</span>

                                                    <!-- Garis tengah -->
                                                    <div class="mx-3 self-stretch w-px bg-gray-300"></div>

                                                    <i class="fa-regular fa-calendar text-sm text-[#7753AF] mr-3"></i>

                                                    <span>{{ \Carbon\Carbon::parse($activity->activity->end_date)->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h3 class="text-md font-bold text-gray-900">
                                                {{ $activity->activity->title }}
                                            </h3>

                                            <div class="text-sm text-gray-800 mb-2">
                                                {{ $activity->activity->description }}
                                            </div>

                                            <a href="{{ route('frontend.kegiatan.show', $activity->activity->id) }}"
                                                class="text-[#7C3AED] text-sm font-semibold">Lihat Detail Kegiatan</a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10 bg-gray-50 rounded-3xl border border-gray-100">
                                        <p class="text-gray-400 font-medium">Belum ada kegiatan diikuti.</p>
                                    </div>
                                @endforelse

                                <div class="pt-0">
                                    {{ $activity_histories->links('vendor.pagination.tailwind-activity') }}
                                </div>













                            </div>
                        </div>
                    </div>









                </div>














            </div>






        </div>






    </div>
    </div>


    </div>
@endsection
