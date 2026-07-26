<div x-show="loginOpen" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div x-show="loginOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/85 transition-opacity" @click="loginOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

        <div x-show="loginOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="relative overflow-hidden rounded-2xl bg-white text-left shadow-2xl w-full max-w-md md:max-w-5xl my-8"
            @click.away="loginOpen = false">

            <button @click="loginOpen = false"
                class="absolute top-4 right-4 z-20 w-8 h-8 flex items-center justify-center rounded-full bg-black/10 text-gray-600 hover:bg-[#7C3AED] hover:text-white transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2 h-full">

                <div class="order-2 md:order-1 p-10 md:px-16 flex flex-col justify-center h-full">
                    <div x-data="{ userType: '{{ $errors->any() ? 'anggota' : 'anggota' }}' }"
                        @trigger-login-opa.window="userType = 'opa'; $dispatch('open-login-modal')" class="w-full">

                        <div class="text-left mb-2">
                            <div class="flex items-center gap-3 mb-10">
                                <img src="{{ asset('frontend/images/logo.jpeg') }}" alt="Logo" loading="lazy"
                                    decoding="async"
                                    class="h-12 w-12 rounded-full object-cover border-2 border-[#7C3AED]">
                                <span class="flex flex-col leading-tight text-lg font-bold text-gray-900">
                                    <span>Tarantula</span>
                                    <span>Adventure</span>
                                </span>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-900"
                                x-text="userType === 'anggota' ? 'Selamat Datang' : 'Halo, Sobat Anggota Eksternal!'">
                                Sign In Account
                            </h2>
                            <p class="mt-0 text-sm text-gray-500"
                                x-text="userType === 'anggota' ? 'Masuk untuk mengakses layanan Tarantula Adventure sesuai dengan peran dan hak akses Anda.' : 'Masuk menggunakan akun Google untuk mengakses layanan Tarantula Adventure.'">
                                Masukkan email dan password kamu.
                            </p>
                        </div>

                        <div class="flex p-1 mb-2 bg-white rounded-2xl border border-gray-400 relative">
                            <div class="absolute top-1 bottom-1 left-1 w-[calc(50%-4px)] bg-[#7C3AED] rounded-xl shadow-sm transition-transform duration-300 ease-in-out will-change-transform"
                                :class="userType === 'anggota' ? 'translate-x-0' : 'translate-x-full'"></div>

                            <button @click="userType = 'anggota'"
                                class="relative z-10 w-1/2 py-2 text-sm font-medium transition-colors duration-300 text-center rounded-xl"
                                :class="userType === 'anggota' ? 'text-white' : 'text-gray-500 hover:text-gray-700'">
                                Portal Internal
                            </button>

                            <button @click="userType = 'opa'"
                                class="relative z-10 w-1/2 py-2 text-sm font-medium transition-colors duration-300 text-center rounded-xl"
                                :class="userType === 'opa' ? 'text-white' : 'text-gray-500 hover:text-gray-700'">
                                Portal Eksternal
                            </button>
                        </div>

                        {{--
                            Kedua panel (Internal & Eksternal) ditumpuk dalam satu grid cell
                            (col-start-1 row-start-1) dan pakai toggle visibility/opacity, bukan x-show.
                            Ini membuat tinggi container selalu mengikuti panel tertinggi (form login),
                            sehingga ukuran modal tidak berubah saat pindah tab.
                        --}}
                        <div class="grid">

                            {{-- Panel: Portal Internal --}}
                            <div class="col-start-1 row-start-1 transition-opacity duration-300"
                                :class="userType === 'anggota' ? 'opacity-100 visible z-10' :
                                    'opacity-0 invisible pointer-events-none'">

                                <div class="flex items-start gap-2 rounded-lg bg-[#7B679B] mb-3 px-4 py-3 text-white">
                                    <!-- Icon -->
                                    <div class="mt-0.5 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-90"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <!-- Text -->
                                    <p class="text-xs font-light">
                                        <span class="font-semibold">Admin, Tim Logistik, dan Anggota Internal</span>,
                                        <br> Akses penuh untuk mengelola perlengkapan, inventaris, anggota, serta
                                        administrasi organisasi.
                                    </p>
                                </div>

                                <form action="{{ route('login.authenticate') }}" method="POST">
                                    @csrf

                                    @error('auth')
                                        <div class="bg-red-100 border mb-3 border-red-400 text-red-700 px-4 py-3 rounded-xl relative text-sm"
                                            role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div class="mb-4">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Email</label>

                                        {{-- transition-all diganti jadi transition-colors: hanya warna
                                             border/ring yang perlu dianimasikan, bukan seluruh properti CSS --}}
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="block w-full px-4 py-3 border rounded-xl text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-1 focus:ring-gray-500 focus:border-transparent transition-colors duration-150 outline-none text-sm
                                    @error('email') border-red-500 ring-1 ring-red-500 @else border-gray-400 @enderror"
                                            placeholder="nama@email.com">

                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-1">
                                            <label
                                                class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                                        </div>

                                        <input type="password" name="password" required
                                            class="block w-full px-4 py-3 border rounded-xl text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-1 focus:ring-gray-500 focus:border-transparent transition-colors duration-150 outline-none text-sm
                                    @error('password') border-red-500 ring-1 ring-red-500 @else border-gray-400 @enderror"
                                            placeholder="••••••••">

                                        @error('password')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex items-center justify-between text-sm mb-4">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="remember"
                                                class="w-4 h-4 rounded border-gray-300 text-[#7C3AED] focus:ring-[#7C3AED]">
                                            <span class="ml-2 text-gray-600">Ingat saya</span>
                                        </label>
                                        <a href="#" class="text-[#7C3AED] hover:text-[#6D28D9] font-medium">Lupa
                                            Password?</a>
                                    </div>

                                    {{-- transform hover:-translate-y-0.5 + transition-all diganti jadi
                                         transition-colors saja untuk warna, translate tetap dipertahankan
                                         karena transform murah (tidak memicu reflow) --}}
                                    <button type="submit"
                                        class="w-full flex justify-center py-3.5 px-4 rounded-xl shadow-lg shadow-purple-500/30 text-sm font-bold text-white bg-[#7C3AED] hover:bg-[#6D28D9] hover:-translate-y-0.5 transition-colors duration-200">
                                        Login
                                    </button>
                                </form>
                            </div>

                            {{-- Panel: Portal Eksternal --}}
                            <div class="col-start-1 row-start-1 transition-opacity duration-300"
                                :class="userType === 'opa' ? 'opacity-100 visible z-10' :
                                    'opacity-0 invisible pointer-events-none'">

                                <div class="flex items-start gap-3 mb-6 rounded-lg bg-[#7B679B] px-4 py-3 text-white">
                                    <!-- Icon -->
                                    <div class="mt-0.5 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-90"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <!-- Text -->
                                    <p class="text-xs font-light">
                                        <span class="font-semibold">Khusus Anggota MAPALA dari Kampus Lain</span>,
                                        <br> Untuk mengajukan peminjaman alat sebagai anggota eksternal silakan masuk
                                        menggunakan akun Google
                                        Anda.
                                    </p>
                                </div>

                                <div class="pt-4">
                                    {{--
                                        Overlay hover diganti dari "w-0 -> w-full" (animasi width, mahal
                                        karena memicu reflow tiap frame) jadi "scale-x-0 -> scale-x-100"
                                        (animasi transform, dihitung di GPU tanpa reflow). origin-left
                                        supaya arah membesarnya tetap dari kiri ke kanan seperti sebelumnya.
                                    --}}
                                    <a href="{{ route('google.redirect') }}"
                                        class="w-full flex items-center justify-center gap-3 py-3.5 px-4 rounded-xl border border-gray-400 bg-white text-sm font-bold text-gray-700 hover:text-gray-900 hover:border-gray-400 transition-colors duration-200 relative overflow-hidden group">

                                        <div
                                            class="absolute inset-0 origin-left scale-x-0 bg-gray-100 opacity-50 transition-transform duration-[250ms] ease-out group-hover:scale-x-100 will-change-transform">
                                        </div>

                                        <svg class="w-5 h-5 relative z-10" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M23.766 12.2764C23.766 11.4607 23.6999 10.6406 23.5588 9.83807H12.24V14.4591H18.7217C18.4528 15.9494 17.5885 17.2678 16.323 18.1056V21.1039H20.19C22.4608 19.0139 23.766 15.9274 23.766 12.2764Z"
                                                fill="#4285F4" />
                                            <path
                                                d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1904 21.1039L16.3233 18.1056C15.2517 18.8375 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z"
                                                fill="#34A853" />
                                            <path
                                                d="M5.50253 14.3003C5.00236 12.8099 5.00236 11.1961 5.50253 9.70575V6.61481H1.51649C-0.18551 10.0056 -0.18551 14.0004 1.51649 17.3912L5.50253 14.3003Z"
                                                fill="#FBBC05" />
                                            <path
                                                d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8439 6.54867L20.2695 3.12262C18.1001 1.0855 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.61481L5.50264 9.70575C6.45064 6.86173 9.10947 4.74966 12.2401 4.74966Z"
                                                fill="#EA4335" />
                                        </svg>
                                        <span class="relative z-10">Masuk dengan Google</span>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="mt-7 flex flex-col items-center justify-center text-center opacity-60">
                        <span class="text-[12px] font-bold tracking-widest text-gray-400 uppercase">
                            Tarantula Adventure
                        </span>
                        <span class="text-[12px] text-gray-400">
                            Universitas Bina Sarana Informatika Yogyakarta
                        </span>
                    </div>
                </div>

                {{--
                    Overlay gradient sebelumnya pakai mix-blend-multiply, yang mahal untuk
                    rendering (browser harus menghitung blending piksel per piksel, terutama
                    berat di device low-end/mobile). Diganti gradient solid biasa tanpa
                    blend mode, hasil visualnya tetap gelap-ke-terang seperti sebelumnya.
                --}}
                <div class="order-1 md:order-2 hidden md:block relative h-full min-h-[600px] bg-white p-3">
                    <div class="relative w-full h-full rounded-xl overflow-hidden">
                        <img src="{{ asset('frontend/images/login.jpeg') }}" alt="Login Background" loading="lazy"
                            decoding="async" class="absolute inset-0 w-full h-full object-cover">

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#7C3AED]/90 via-[#7C3AED]/40 to-transparent mix-blend-multiply">
                        </div>

                        <div class="absolute bottom-0 left-0 p-10 text-white z-10">
                            <h3 class="text-3xl font-bold mb-2 leading-tight">Satu Sistem, <br>Beragam
                                Kebutuhan</h3>
                            <p class="text-gray-100 text-sm opacity-90">Dirancang untuk membantu pengelolaan
                                perlengkapan, anggota, logistik, dan berbagai aktivitas Tarantula Adventure dalam satu
                                platform.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{--
    PENTING: Tambahkan script ini sebelum penutup </body>,
    atau gabungkan ke dalam x-init parent jika loginOpen sudah ada di scope parent x-data.
    Script ini memaksa modal terbuka kembali jika ada error validasi setelah redirect dari Laravel.
--}}
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.dispatchEvent(new CustomEvent('open-login-modal'));
        });
    </script>
@endif
