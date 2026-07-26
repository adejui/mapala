<div x-show="loginOpen" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div x-show="loginOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" @click="loginOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

        <div x-show="loginOpen" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-md md:max-w-6xl my-8"
            @click.away="loginOpen = false">

            <button @click="loginOpen = false"
                class="absolute top-4 right-4 z-20 w-8 h-8 flex items-center justify-center rounded-full bg-black/10 text-gray-600 hover:bg-[#7C3AED] hover:text-white transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2 h-full">

                <div class="hidden md:block relative h-full min-h-[600px] bg-gray-100">
                    <img src="{{ asset('frontend/images/login.jpeg') }}" alt="Login Background"
                        class="absolute inset-0 w-full h-full object-cover">

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-[#7C3AED]/90 via-[#7C3AED]/40 to-transparent mix-blend-multiply">
                    </div>

                    <div class="absolute bottom-0 left-0 p-10 text-white z-10">
                        <h3 class="text-3xl font-bold mb-2 leading-tight">Welcome Back,<br>Adventurer!</h3>
                        <p class="text-gray-100 text-sm opacity-90">Siap melanjutkan perjalananmu? Masuk sekarang untuk
                            akses dashboard anggota.</p>
                    </div>
                </div>

                <div class="p-10 md:p-16 flex flex-col justify-center h-full">=
                    <div x-data="{ userType: 'anggota' }"
                        @trigger-login-opa.window="userType = 'opa'; $dispatch('open-login-modal')" class="w-full">

                        <div class="text-center mb-8">
                            <img src="{{ asset('frontend/images/logo.jpeg') }}" alt="Logo"
                                class="mx-auto h-12 w-12 rounded-full object-cover border-2 border-[#7C3AED] mb-4">

                            <h2 class="text-2xl font-bold text-gray-900"
                                x-text="userType === 'anggota' ? 'Sign In Anggota' : 'Halo, Sobat OPA!'">
                                Sign In Account
                            </h2>

                            <p class="mt-2 text-sm text-gray-500"
                                x-text="userType === 'anggota' ? 'Masukkan email dan password kamu.' : 'Silakan masuk praktis dengan akun Google.'">
                                Masukkan email dan password kamu.
                            </p>
                        </div>


                        <div class="flex p-1 mb-6 bg-gray-100 rounded-xl border border-gray-200 relative">
                            <div class="absolute top-1 bottom-1 left-1 w-[calc(50%-4px)] bg-white rounded-lg shadow-sm transition-all duration-300 ease-out"
                                :class="userType === 'anggota' ? 'translate-x-0' : 'translate-x-full'"></div>

                            <button @click="userType = 'anggota'"
                                class="relative z-10 w-1/2 py-2 text-sm font-bold transition-colors duration-300 text-center rounded-lg"
                                :class="userType === 'anggota' ? 'text-[#7C3AED]' : 'text-gray-500 hover:text-gray-700'">
                                Anggota Mapala
                            </button>

                            <button @click="userType = 'opa'"
                                class="relative z-10 w-1/2 py-2 text-sm font-bold transition-colors duration-300 text-center rounded-lg"
                                :class="userType === 'opa' ? 'text-[#7C3AED]' : 'text-gray-500 hover:text-gray-700'">
                                OPA / Umum
                            </button>
                        </div>


                        <div x-show="userType === 'anggota'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0">

                            <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-5">
                                @csrf

                                @if ($errors->has('email'))
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm"
                                        role="alert">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif

                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Email</label>

                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="block w-full px-4 py-3 border rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-[#7C3AED] focus:border-transparent transition-all outline-none text-sm
                                @error('email') border-red-500 ring-red-500 @else border-gray-200 @enderror"
                                        placeholder="nama@email.com">

                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                                    </div>

                                    <input type="password" name="password" required
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-[#7C3AED] focus:border-transparent transition-all outline-none text-sm"
                                        placeholder="••••••••">
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="remember"
                                            class="w-4 h-4 rounded border-gray-300 text-[#7C3AED] focus:ring-[#7C3AED]">
                                        <span class="ml-2 text-gray-600">Ingat saya</span>
                                    </label>
                                    <a href="#" class="text-[#7C3AED] hover:text-[#6D28D9] font-medium">Lupa
                                        Password?</a>
                                </div>

                                <button type="submit"
                                    class="w-full flex justify-center py-3.5 px-4 rounded-xl shadow-lg shadow-purple-500/30 text-sm font-bold text-white bg-[#7C3AED] hover:bg-[#6D28D9] transform hover:-translate-y-0.5 transition-all duration-200">
                                    Sign In Anggota
                                </button>
                            </form>
                        </div>


                        <div x-show="userType === 'opa'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                            <div class="text-center space-y-4 py-4">
                                <div
                                    class="w-16 h-16 bg-purple-50 rounded-full flex items-center justify-center mx-auto text-[#7C3AED] mb-4">
                                    <i class="fa-solid fa-users-viewfinder text-2xl"></i>
                                </div>

                                <h3 class="text-lg font-bold text-gray-900">Selamat Datang, Sobat Petualang!</h3>

                                <p class="text-gray-500 text-sm leading-relaxed px-4">
                                    Untuk mengajukan peminjaman alat sebagai <strong>Peminjam Luar (OPA)</strong>,
                                    silakan masuk menggunakan akun Google Anda demi keamanan data.
                                </p>

                                <div class="pt-4">
                                    {{-- <a href="{{ url('/auth/google') }}" --}}
                                    <a href="{{ route('google.redirect') }}"
                                        class="w-full flex items-center justify-center gap-3 py-3.5 px-4 rounded-xl border border-gray-300 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-gray-900 hover:border-gray-400 transition-all duration-200 shadow-sm relative overflow-hidden group">

                                        <div
                                            class="absolute inset-0 w-0 bg-gray-100 transition-all duration-[250ms] ease-out group-hover:w-full opacity-50">
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

                                <p class="text-xs text-gray-400 mt-4">
                                    Tidak punya akun Google? Hubungi admin.
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="mt-10 flex flex-col items-center justify-center text-center opacity-60">
                        <span class="text-[12px] font-bold tracking-widest text-gray-400 uppercase">
                            Tarantula Adventure
                        </span>
                        <span class="text-[10px] text-gray-400 mt-1">
                            Portal Anggota & Alumni
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
