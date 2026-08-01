@extends('frontend.layouts.app')

@section('content')
    <div class="mb-5 flex justify-end">
        @if (session('success'))
            <x-alert-success title="Berhasil!" :message="session('success')" />
        @endif
    </div>
    @if (session('error'))
        <div class="mb-5 flex justify-end">
            <x-alert-error title="Gagal!" :message="session('error')" />
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 max-w-7xl mx-auto"
            role="alert">
            <strong class="font-bold">Ada kesalahan input!</strong>
            <span class="block sm:inline">Silakan periksa kembali formulir di bawah ini.</span>
        </div>
    @endif

    <div class="bg-gray-50 min-h-screen pt-32 pb-20 px-6 md:px-16">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Peminjaman</h1>
                    <p class="text-gray-500 mt-1 text-sm">Lengkapi data peminjaman untuk proses verifikasi dan pengambilan
                        alat.</p>
                </div>
                <nav class="flex text-sm font-medium text-gray-500">
                    <a href="{{ route('frontend.home') }}" class="hover:text-[#7C3AED] transition-colors">Home</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('frontend.inventory') }}"
                        class="hover:text-[#7C3AED] transition-colors">Inventaris</a>
                    <span class="mx-2">/</span>
                    <span class="text-[#7C3AED]">Peminjaman</span>
                </nav>
            </div>

            @php

                $showCompleteProfileModal = false;

                // USER LOGIN
                if (auth('web')->check()) {
                    $user = auth('web')->user();

                    if (empty($user->full_name) || empty($user->email) || empty($user->phone_number)) {
                        $showCompleteProfileModal = true;
                    }
                }

                // OPA LOGIN
                if (auth('opa')->check()) {
                    $opa = auth('opa')->user();

                    if (
                        empty($opa->name) ||
                        empty($opa->email) ||
                        empty($opa->campus_name) ||
                        empty($opa->organization_name) ||
                        empty($opa->phone_number)
                    ) {
                        $showCompleteProfileModal = true;
                    }
                }

            @endphp

            <form id="loanForm" action="{{ route('frontend.pinjaman.store') }}" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="cart_items" id="cart_items_input" value="{{ json_encode($cartItems) }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-4">

                        <div class="bg-white rounded-4xl border border-gray-100 p-8 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Data Peminjam</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                        Nama Lengkap
                                    </label>

                                    <input type="text" name="name" readonly
                                        value="{{ old(
                                            'name',
                                            auth('opa')->check() ? auth('opa')->user()->name : (auth()->check() ? auth()->user()->full_name : ''),
                                        ) }}"
                                        class="w-full bg-gray-200 border rounded-xl px-4 py-3.5
               focus:outline-none transition-all text-sm font-medium text-gray-900 placeholder-gray-400"
                                        placeholder="Masukkan nama lengkap sesuai KTP...">

                                </div>


                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Kampus
                                        Asal</label>
                                    <input type="text" name="campus_name"
                                        value="{{ old('campus_name', auth('opa')->check() ? auth('opa')->user()->campus_name ?? '' : 'UBSI Yogyakarta') }}"
                                        readonly
                                        class="w-full bg-gray-200 border rounded-xl px-4 py-3.5 focus:outline-none transition-all text-sm font-medium text-gray-900 placeholder-gray-400"
                                        placeholder="Contoh: UBSI Yogyakarta">

                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Organisasi
                                    </label>
                                    <input type="text" name="organization_name"
                                        value="{{ old('organization_name', auth('opa')->check() ? auth('opa')->user()->organization_name ?? '' : 'Mapala Tarantula') }}"
                                        readonly
                                        class="w-full bg-gray-200 border rounded-xl px-4 py-3.5 focus:outline-none transition-all text-sm font-medium text-gray-900 placeholder-gray-400"
                                        placeholder="Mapala / UKM / Umum">

                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                        No WhatsApp
                                    </label>

                                    <input type="number" name="phone_number"
                                        value="{{ old(
                                            'phone_number',
                                            auth('opa')->check() ? auth('opa')->user()->phone_number ?? '' : auth('web')->user()->phone_number ?? '',
                                        ) }}"
                                        readonly
                                        class="w-full bg-gray-200 border rounded-xl px-4 py-3.5
               focus:outline-none
               transition-all text-sm font-medium text-gray-900 placeholder-gray-400"
                                        placeholder="08xxxxxxxxxx">

                                </div>


                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                        Email
                                    </label>

                                    <input type="email" name="email"
                                        value="{{ old(
                                            'email',
                                            auth('opa')->check() ? auth('opa')->user()->email : (auth()->check() ? auth()->user()->email : ''),
                                        ) }}"
                                        class="w-full bg-gray-200 border rounded-xl px-4 py-3.5
               focus:outline-none
               transition-all text-sm font-medium text-gray-900 placeholder-gray-400"
                                        placeholder="email@domain.com" readonly>

                                </div>

                            </div>
                        </div>


                        <div class="bg-white rounded-4xl border border-gray-100 p-8 shadow-sm">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                        Tanggal Pinjam <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="borrow_date" id="borrow_date"
                                            value="{{ old('borrow_date') }}"
                                            class="w-full bg-gray-50 border rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white transition-all text-sm font-medium text-gray-500 uppercase cursor-pointer
            @error('borrow_date') border-red-500 ring-1 ring-red-500 @else border-gray-200 @enderror"
                                            onclick="this.showPicker()">
                                    </div>
                                    <p id="borrow_date_error"
                                        class="text-red-500 text-xs mt-1 {{ $errors->has('borrow_date') ? '' : 'hidden' }}">
                                        {{ $errors->first('borrow_date') ?: 'Tanggal pinjam wajib diisi.' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                                        Tanggal Pengembalian <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="return_date" id="return_date"
                                            value="{{ old('return_date') }}"
                                            class="w-full bg-gray-50 border rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white transition-all text-sm font-medium text-gray-500 uppercase cursor-pointer
            @error('return_date') border-red-500 ring-1 ring-red-500 @else border-gray-200 @enderror"
                                            onclick="this.showPicker()">
                                    </div>
                                    <p id="return_date_error"
                                        class="text-red-500 text-xs mt-1 {{ $errors->has('return_date') ? '' : 'hidden' }}">
                                        {{ $errors->first('return_date') ?: 'Tanggal pengembalian wajib diisi.' }}
                                    </p>
                                </div>

                                <div class="md:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Keperluan
                                        Peminjaman <span class="text-red-500">*</span></label>
                                    <textarea rows="4" name="notes" id="notes"
                                        class="w-full bg-gray-50 border rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-[#7C3AED] focus:bg-white transition-all text-sm font-medium text-gray-900 placeholder-gray-400
                                                @error('notes') border-red-500 ring-1 ring-red-500 @else border-gray-200 @enderror"
                                        placeholder="Jelaskan keperluan peminjaman secara detail...">{{ old('notes') }}</textarea>

                                    <p id="notes_error"
                                        class="text-red-500 text-xs mt-1 {{ $errors->has('notes') ? '' : 'hidden' }}">
                                        {{ $errors->first('notes') ?: 'Keperluan peminjaman wajib diisi.' }}
                                    </p>
                                </div>

                            </div>

                        </div>


                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-4xl border border-gray-100 p-6 shadow-sm sticky top-32">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Ringkasan Peminjaman</h3>

                            <div class="space-y-4 mb-8 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                                @forelse ($cartItems as $item)
                                    <div
                                        class="flex gap-4 p-3 border border-gray-100 rounded-2xl bg-white hover:border-purple-100 transition-colors group">
                                        <div
                                            class="h-20 w-20 shrink-0 bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center border border-gray-100">
                                            <img src="{{ $item['photo'] ? asset('storage/' . $item['photo']) : asset('frontend/images/tas.jpg') }}"
                                                class="h-full w-full object-contain p-0 mix-blend-multiply group-hover:scale-110 transition-transform">
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h4 class="font-bold text-gray-900 text-sm line-clamp-2 leading-tight">
                                                {{ $item['name'] }}
                                            </h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded font-mono">#{{ $item['code'] }}</span>
                                                <span class="text-xs text-gray-400">|</span>
                                                <span class="text-xs font-bold text-[#7C3AED]">{{ $item['qty'] }}
                                                    Unit</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-gray-400 text-sm">Keranjang kosong.</div>
                                @endforelse
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-[#7753AF] hover:bg-[#5e3d8e] text-white font-bold rounded-xl shadow-lg shadow-purple-200 transition-all transform hover:-translate-y-1 active:scale-95">
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>


    <div id="completeProfileModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">

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

                <!-- Icon -->
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

                <!-- Title -->
                <h2 class="text-tarantulaPurple text-xl font-bold dark:text-white">
                    Lengkapi Profile
                </h2>

                <!-- Description -->
                <div class="text-sm text-gray-500 dark:text-gray-300 mt-2 leading-relaxed">

                    <p>Lengkapi profilmu dulu agar bisa meminjam barang.</p>
                    <p>Hanya butuh <span class="text-tarantulaPurple font-semibold">1 menit</span> untuk melengkapi</p>
                    <p>data
                        yang
                        diperlukan.</p>
                </div>

                <!-- Button -->
                <div class="mt-6">

                    @if (auth()->guard('web')->check())
                        <a href="{{ route('frontend.user.profile') }}"
                            class="inline-flex items-center justify-center w-full px-6 py-2 text-md text-white font-light rounded-xl bg-purple-600 hover:bg-purple-700 transition duration-300 shadow-md">

                            Ke Halaman Profile
                            <span class="ml-2">→</span>
                        </a>
                    @elseif(auth()->guard('opa')->check())
                        <a href="{{ route('frontend.opa.profile') }}"
                            class="inline-flex items-center justify-center w-full px-6 py-2 text-md text-white font-light rounded-xl bg-purple-600 hover:bg-purple-700 transition duration-300 shadow-md">

                            Ke Halaman Profile
                            <span class="ml-2">→</span>
                        </a>
                    @endif

                    <!-- Nanti saja -->
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

            const form = document.getElementById("loanForm");
            const modal = document.getElementById("completeProfileModal");
            const closeButtons = document.querySelectorAll(".closeCompleteProfileModal");

            const isProfileComplete = @json($isProfileComplete);

            const borrowDateInput = document.getElementById('borrow_date');
            const returnDateInput = document.getElementById('return_date');
            const notesInput = document.getElementById('notes');

            const borrowDateError = document.getElementById('borrow_date_error');
            const returnDateError = document.getElementById('return_date_error');
            const notesError = document.getElementById('notes_error');

            function showFieldError(input, errorEl, message) {
                input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                input.classList.remove('border-gray-200');
                if (message) {
                    errorEl.textContent = message;
                }
                errorEl.classList.remove('hidden');
            }

            function clearFieldError(input, errorEl) {
                input.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                input.classList.add('border-gray-200');
                errorEl.classList.add('hidden');
            }

            // Bersihkan error saat user mulai mengisi field
            borrowDateInput.addEventListener('input', () => clearFieldError(borrowDateInput, borrowDateError));
            returnDateInput.addEventListener('input', () => clearFieldError(returnDateInput, returnDateError));
            notesInput.addEventListener('input', () => clearFieldError(notesInput, notesError));

            // Submit form
            form.addEventListener("submit", function(e) {

                e.preventDefault();

                // 1. Cek dulu kelengkapan Data Peminjam.
                //    Kalau belum lengkap, modal "Lengkapi Profile" WAJIB muncul,
                //    apapun kondisi tanggal/keperluan (tidak perlu validasi field lain dulu).
                if (!isProfileComplete) {
                    modal.classList.remove("hidden");
                    modal.classList.add("flex");
                    return;
                }

                // 2. Data Peminjam sudah lengkap -> baru validasi Tanggal Pinjam,
                //    Tanggal Pengembalian & Keperluan Peminjaman.
                //    Kalau belum diisi -> munculkan pesan merah, JANGAN munculkan modal.
                let isValid = true;

                if (!borrowDateInput.value) {
                    showFieldError(borrowDateInput, borrowDateError, 'Tanggal pinjam wajib diisi.');
                    isValid = false;
                } else {
                    clearFieldError(borrowDateInput, borrowDateError);
                }

                if (!returnDateInput.value) {
                    showFieldError(returnDateInput, returnDateError, 'Tanggal pengembalian wajib diisi.');
                    isValid = false;
                } else {
                    clearFieldError(returnDateInput, returnDateError);
                }

                if (!notesInput.value.trim()) {
                    showFieldError(notesInput, notesError, 'Keperluan peminjaman wajib diisi.');
                    isValid = false;
                } else {
                    clearFieldError(notesInput, notesError);
                }

                if (!isValid) {
                    const firstError = form.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                    return;
                }

                // 3. Semua valid, submit form ke server
                form.submit();
            });

            // Semua tombol close modal
            closeButtons.forEach(button => {

                button.addEventListener("click", function() {

                    modal.classList.add("hidden");
                    modal.classList.remove("flex");

                });

            });

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const borrowInput = document.getElementById('borrow_date');
            const returnInput = document.getElementById('return_date');

            const today = new Date();
            const todayFormatted = today.toISOString().split('T')[0];

            // Max borrow = hari ini + 14 hari
            const maxBorrow = new Date();
            maxBorrow.setDate(today.getDate() + 14);
            const maxBorrowFormatted = maxBorrow.toISOString().split('T')[0];

            // Set min & max borrow
            borrowInput.setAttribute('min', todayFormatted);
            borrowInput.setAttribute('max', maxBorrowFormatted);

            // Default return min
            returnInput.setAttribute('min', todayFormatted);

            borrowInput.addEventListener('change', function() {
                const borrowDate = new Date(this.value);

                // Min return = borrow date
                returnInput.setAttribute('min', this.value);

                // Max return = borrow + 14 hari
                const maxReturn = new Date(borrowDate);
                maxReturn.setDate(maxReturn.getDate() + 14);
                const maxReturnFormatted = maxReturn.toISOString().split('T')[0];

                returnInput.setAttribute('max', maxReturnFormatted);

                // Validasi isi return
                if (returnInput.value > maxReturnFormatted) {
                    returnInput.value = maxReturnFormatted;
                }

                if (returnInput.value && returnInput.value < this.value) {
                    returnInput.value = this.value;
                }
            });
        });
    </script>
@endsection
