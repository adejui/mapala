@extends('frontend.layouts.app')

@section('content')
    <div class="bg-white min-h-screen pt-32 pb-20 px-6 md:px-16">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Alat</h1>
                    <p class="text-gray-500 mt-1">Informasi lengkap mengenai spesifikasi dan kondisi alat.</p>
                </div>
                <nav class="flex text-sm font-medium text-gray-500">
                    <a href="{{ route('frontend.home') }}" class="hover:text-[#7C3AED] transition-colors">Home</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('frontend.inventory') }}" class="hover:text-[#7C3AED] transition-colors">Inventoris</a>
                    <span class="mx-2">/</span>
                    <span class="text-[#7C3AED]">Detail Alat</span>
                </nav>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">

                @php
                    $photos = $item->photos->take(5);
                    $mainPhoto = $photos->first();
                    $thumbnails = $photos->slice(1);
                @endphp

                <div class="space-y-4">

                    {{-- MAIN IMAGE --}}
                    <div
                        class="w-full aspect-[4/3] bg-white border-2 border-grey-500 rounded-3xl overflow-hidden flex items-center justify-center">

                        <img id="mainImage"
                            src="{{ $mainPhoto ? asset('storage/' . $mainPhoto->photo_path) : asset('frontend/images/no-image.png') }}"
                            class="w-full h-full object-contain mix-blend-multiply transition duration-300">

                    </div>

                    {{-- THUMBNAILS --}}
                    <div class="grid grid-cols-4 gap-4">

                        @forelse ($thumbnails as $photo)
                            <div onclick="changeImage(this)"
                                class="aspect-square p-2 bg-white rounded-2xl cursor-pointer border-2 border-grey-500 hover:border-2 hover:border-[#7C3AED] transition flex items-center justify-center">

                                <img src="{{ asset('storage/' . $photo->photo_path) }}"
                                    class="thumb w-full h-full object-contain opacity-70 hover:opacity-100">

                            </div>
                        @empty
                            <div class="col-span-4 text-center text-gray-400 text-sm">
                                Tidak ada foto tambahan
                            </div>
                        @endforelse

                    </div>

                </div>

                {{-- SCRIPT --}}
                <script>
                    function changeImage(el) {
                        const main = document.getElementById('mainImage');
                        const thumbImg = el.querySelector('img');

                        // SWAP IMAGE (biar tidak duplikat)
                        const temp = main.src;
                        main.src = thumbImg.src;
                        thumbImg.src = temp;
                    }
                </script>


                <div class="flex flex-col py-8">

                    <h2 class="text-4xl font-bold text-gray-900 mb-6">{{ $item->name }}</h2>

                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Deskripsi</h3>
                        <p class="text-gray-500 leading-relaxed text-justify">
                            {{ $item->description }}
                        </p>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Kategori</h3>
                        <span class="inline-block bg-gray-100 text-gray-600 px-4 py-1.5 rounded-full text-sm font-medium">
                            {{ $item->category->name }}
                        </span>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Stock</h3>

                        <div class="flex items-center gap-4">

                            {{-- BUTTON QTY --}}
                            {{-- <div class="flex items-center border border-gray-300 rounded-xl px-2 py-1">

                                <button type="button" id="btn-minus"
                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-[#7C3AED] transition text-lg font-bold">
                                    -
                                </button>

                                <input type="text" id="qty" name="qty" value="1"
                                    class="w-8 text-center text-gray-900 font-bold focus:outline-none border-none p-0"
                                    readonly>

                                <button type="button" id="btn-plus"
                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-[#7C3AED] transition text-lg font-bold">
                                    +
                                </button>

                            </div> --}}

                            {{-- STOCK INFO --}}
                            <span
                                class="text-sm font-medium flex items-center gap-1
            {{ $item->quantity > 0 ? 'text-green-600' : 'text-red-500' }}">

                                @if ($item->quantity > 0)
                                    <i class="fa-solid fa-check-circle"></i>
                                    Tersedia {{ $item->quantity }} Unit
                                @else
                                    <i class="fa-solid fa-xmark-circle"></i>
                                    Stok Habis
                                @endif

                            </span>

                        </div>
                    </div>

                    {{-- JAVASCRIPT --}}
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {

                            let maxStock = {{ $item->quantity ?? 0 }};
                            let qtyInput = document.getElementById('qty');
                            let btnPlus = document.getElementById('btn-plus');
                            let btnMinus = document.getElementById('btn-minus');

                            // kalau stok habis
                            if (maxStock <= 0) {
                                qtyInput.value = 0;
                                btnPlus.disabled = true;
                                btnMinus.disabled = true;
                                return;
                            }

                            btnPlus.addEventListener('click', function() {
                                let current = parseInt(qtyInput.value) || 1;

                                if (current < maxStock) {
                                    qtyInput.value = current + 1;
                                }
                            });

                            btnMinus.addEventListener('click', function() {
                                let current = parseInt(qtyInput.value) || 1;

                                if (current > 1) {
                                    qtyInput.value = current - 1;
                                }
                            });

                        });
                    </script>

                    {{-- BUTTON HANYA MUNCUL JIKA STOK ADA --}}
                    @if ($item->quantity > 0)
                        <div class="flex flex-col sm:flex-row gap-4 mt-0">

                            {{-- === USER LOGIN (WEB ATAU OPA) === --}}
                            @if (auth()->check() || auth('opa')->check())
                                {{-- Masukan Keranjang --}}
                                <button onclick="addToCart({{ $item->id }})"
                                    class="flex-1 py-3 mt-8 px-4 rounded-xl bg-[#7753AF]
                text-white font-bold hover:bg-[#5e3d8e]
                transition-all duration-300 shadow-md active:scale-95">
                                    Masukan Keranjang
                                </button>
                            @else
                                {{-- Guest --}}
                                <button
                                    onclick="Swal.fire({
                    icon: 'warning',
                    title: 'Login Dulu!',
                    text: 'Untuk menggunakan fitur keranjang, silakan login terlebih dahulu.',
                    confirmButtonText: 'Login',
                    confirmButtonColor: '#7C3AED',
                    showCancelButton: true,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.dispatchEvent(new CustomEvent('trigger-login-opa'));
                    }
                })"
                                    class="flex-1 py-3 px-4 rounded-xl bg-gray-300
                text-white font-bold hover:bg-gray-400
                transition-all duration-300 shadow-md">
                                    Masukan Keranjang
                                </button>

                                {{-- <button
                                    onclick="Swal.fire({
                    icon: 'warning',
                    title: 'Login Dulu!',
                    text: 'Silakan login terlebih dahulu untuk melakukan peminjaman.',
                    confirmButtonText: 'Login',
                    confirmButtonColor: '#7C3AED',
                    showCancelButton: true,
                    cancelButtonText: 'Nanti Saja'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.dispatchEvent(new CustomEvent('trigger-login-opa'));
                    }
                })"
                                    class="flex-1 py-3 px-4 rounded-xl border-2 border-gray-300
                text-gray-400 font-bold hover:border-[#7C3AED]
                hover:text-[#7C3AED] transition-all duration-300">
                                    Pinjam Sekarang
                                </button> --}}
                            @endif

                        </div>
                    @endif


                </div>
            </div>

            <div class="border-t border-gray-100 pt-12 sm:pt-16">

                <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 sm:mb-8 gap-3">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Inventaris Peralatan</h2>
                        <p class="text-gray-500 text-sm mt-1">Pastikan setiap item siap untuk ekspedisi Anda berikutnya.</p>
                    </div>
                    <a href="{{ route('frontend.inventory') }}"
                        class="inline-block bg-[#7753AF] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#5e3d8e] transition text-center">
                        Lihat Semua
                    </a>
                </div>

                {{-- card --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-6 mb-12">

                    @forelse ($relatedItems as $item)
                        @php
                            $itemPhoto = $item->photos->first();
                        @endphp
                        <div
                            class="w-full bg-white border-2 border-gray-200 rounded-2xl sm:rounded-3xl flex flex-col hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden group h-full">

                            <a href="{{ route('frontend.inventory.show', $item->id) }}"
                                class="relative w-full h-36 sm:h-48 md:h-56 bg-gray-100 flex items-center justify-center overflow-hidden">

                                <span
                                    class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-black/20 backdrop-blur-sm text-black text-[9px] sm:text-[10px] font-bold px-2 sm:px-3 py-0.5 sm:py-1 rounded-full uppercase tracking-wide z-10">
                                    {{ $item->category->name ?? 'Umum' }}
                                </span>

                                <img src="{{ $itemPhoto ? asset('storage/' . $itemPhoto->photo_path) : asset('frontend/images/tas.jpg') }}"
                                    alt="{{ $item->name }}"
                                    class="w-full h-full object-contain pt-8 sm:pt-11 px-4 sm:px-6 mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                            </a>

                            <div class="p-3 sm:p-5 flex justify-between items-end gap-2 grow border-t border-gray-100">
                                <div class="min-w-0">
                                    <h3
                                        class="text-gray-900 font-semibold text-sm sm:text-base leading-tight mb-1 line-clamp-2">
                                        {{ $item->name }}
                                    </h3>

                                    <p class="text-gray-500 text-xs sm:text-sm font-medium">
                                        @if ($item->quantity > 0)
                                            Tersedia {{ $item->quantity }} Unit
                                        @else
                                            Stok Habis
                                        @endif
                                    </p>
                                </div>

                                <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">

                                    @if ($item->quantity > 0 && (auth()->check() || auth('opa')->check()))
                                        <button type="button" onclick="addToCart({{ $item->id }})"
                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl border-2 border-[#7C3AED] text-[#7C3AED] flex items-center justify-center hover:bg-[#7C3AED] hover:text-white transition-all duration-300 shadow-sm group/cart"
                                            title="Tambah ke Keranjang">
                                            <i
                                                class="fa-solid fa-plus text-xs sm:text-sm group-hover/cart:rotate-90 transition-transform duration-300"></i>
                                        </button>
                                    @elseif ($item->quantity > 0)
                                        <button type="button"
                                            onclick="Swal.fire({
                                    icon: 'warning',
                                    title: 'Login Dulu!',
                                    text: 'Untuk menggunakan fitur keranjang, silakan login terlebih dahulu.',
                                    confirmButtonText: 'Login',
                                    confirmButtonColor: '#7C3AED',
                                    showCancelButton: true,
                                    cancelButtonText: 'Nanti Saja'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.dispatchEvent(new CustomEvent('trigger-login-opa'));
                                    }
                                })"
                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl border-2 border-gray-300 text-gray-400 flex items-center justify-center hover:border-[#7C3AED] hover:text-[#7C3AED] transition-all duration-300 shadow-sm"
                                            title="Tambah ke Keranjang">
                                            <i class="fa-solid fa-plus text-xs sm:text-sm"></i>
                                        </button>
                                    @endif

                                    <a href="{{ route('frontend.inventory.show', $item->id) }}"
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-[#7753AF] rounded-lg sm:rounded-xl flex items-center justify-center text-white hover:bg-[#5e3d8e] hover:scale-110 transition-all duration-300 shadow-md group/btn"
                                        title="Lihat Detail">
                                        <i
                                            class="fa-solid fa-arrow-right -rotate-45 group-hover/btn:rotate-0 transition-transform duration-300 text-xs sm:text-base"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-12 sm:py-16 text-center">
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400 text-2xl sm:text-3xl">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Belum ada barang terkait</h3>
                            <p class="text-gray-500 text-sm">Inventaris saat ini masih kosong.</p>
                        </div>
                    @endforelse

                </div>
            </div>


        </div>
    </div>





    <div onclick="toggleCart()" class="fixed bottom-8 right-8 z-40">
        <button
            class="relative w-16 h-16 bg-[#7C3AED] text-white rounded-full shadow-2xl hover:bg-[#6D28D9] hover:scale-110 transition-all duration-300 flex items-center justify-center group">
            <i class="fa-solid fa-cart-shopping text-2xl group-hover:animate-bounce"></i>

            <span id="cart-badge"
                class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center 
            {{ count(session('cart', [])) > 0 ? '' : 'hidden' }}">
                {{ count(session('cart', [])) }}
            </span>

        </button>
    </div>
    <div id="cart-drawer" class="fixed inset-0 z-50 hidden" aria-modal="true">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0 cart-overlay"
            onclick="toggleCart()"></div>

        <!-- Drawer Wrapper -->
        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

            <!-- Drawer Panel -->
            <div id="cart-panel"
                class="pointer-events-auto w-screen max-w-md transform transition-all duration-500 ease-in-out translate-x-full bg-white shadow-2xl flex flex-col h-full">

                <!-- HEADER -->
                <div class="flex items-start justify-between px-6 py-6 border-b border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Keranjang Alat</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            <span id="drawer-count">{{ count(session('cart', [])) }}</span> Jenis Barang dipilih
                        </p>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="toggleCart()">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                    </button>
                </div>

                <!-- CART ITEMS -->
                <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6" id="cart-items">
                    @foreach (session('cart', []) as $cart)
                        <div class="flex gap-4">
                            <div class="h-20 w-20 shrink-0 rounded-xl border border-gray-200 bg-gray-50 overflow-hidden">
                                <img src="{{ $cart['photo'] ? asset('storage/' . $cart['photo']) : asset('frontend/images/tas.jpg') }}"
                                    class="h-full w-full object-contain p-2 mix-blend-multiply">
                            </div>

                            <div class="flex flex-1 flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-semibold text-gray-900">
                                        <h3>{{ $cart['name'] }}</h3>
                                        <p class="ml-4 text-[#7C3AED] font-bold">#{{ $cart['code'] }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Kategori: {{ $cart['category'] }}</p>
                                </div>

                                <div class="flex flex-1 items-end justify-between text-sm mt-2">

                                    <!-- QTY CONTROL -->
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button onclick="updateQty({{ $cart['id'] }}, {{ $cart['qty'] - 1 }})"
                                            class="px-3 py-1 text-gray-600 hover:bg-gray-100 border-r border-gray-300">-</button>

                                        <span class="px-3 py-1 font-medium text-gray-900">{{ $cart['qty'] }}</span>

                                        <button onclick="updateQty({{ $cart['id'] }}, {{ $cart['qty'] + 1 }})"
                                            class="px-3 py-1 text-gray-600 hover:bg-gray-100 border-l border-gray-300">+</button>
                                    </div>

                                    <!-- REMOVE -->
                                    <button onclick="removeItem({{ $cart['id'] }})"
                                        class="font-medium text-red-500 hover:text-red-700 flex items-center gap-1">
                                        <i class="fa-regular fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- FOOTER -->
                <div class="border-t border-gray-100 px-6 py-6 bg-gray-50">
                    <div class="flex justify-between text-base font-semibold text-gray-900 mb-4">

                        <p>Total Barang</p>
                        <p><span id="cart-total">{{ collect(session('cart', []))->sum('qty') }}</span> Unit</p>

                    </div>

                    <p class="text-sm text-gray-500 mb-6">Pastikan barang sudah sesuai sebelum mengajukan peminjaman.</p>

                    <button type="button" id="btn-empty"
                        onclick="Swal.fire({
                            icon: 'warning',
                            title: 'Keranjang Kosong!',
                            text: 'Silakan pilih alat terlebih dahulu.',
                            confirmButtonColor: '#7C3AED'
                        })"
                        class="w-full flex items-center justify-center rounded-xl bg-gray-200 px-6 py-4 text-base font-bold text-gray-400 cursor-not-allowed transition-all {{ count(session('cart', [])) > 0 ? 'hidden' : '' }}">
                        <i class="fa-solid fa-ban mr-2"></i> Keranjang Kosong
                    </button>

                    <a href="{{ route('frontend.pinjaman') }}" id="btn-filled"
                        class="w-full flex items-center justify-center rounded-xl bg-[#7C3AED] px-6 py-4 text-base font-bold text-white shadow-lg hover:bg-[#6D28D9] transition-all transform hover:-translate-y-1 {{ count(session('cart', [])) == 0 ? 'hidden' : '' }}">
                        Lanjut Isi Formulir <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>


                    <div class="mt-6 text-center text-sm text-gray-500">
                        atau
                        <button type="button" class="font-medium text-[#7C3AED]" onclick="toggleCart()">Lanjut Cari
                            Barang
                            →</button>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <script>
        function updateFloatingBadge(total) {
            const badge = document.getElementById("cart-badge");
            if (badge) {
                badge.innerText = total;
                if (total > 0) {
                    badge.classList.remove("hidden");
                } else {
                    badge.classList.add("hidden");
                }
            }
        }


        function toggleCart() {
            const drawer = document.getElementById("cart-drawer");
            const panel = document.getElementById("cart-panel");
            const overlay = document.querySelector(".cart-overlay");

            if (drawer.classList.contains("hidden")) {
                drawer.classList.remove("hidden");
                setTimeout(() => {
                    overlay.classList.remove("opacity-0");
                    panel.classList.remove("translate-x-full");
                }, 10);
            } else {
                overlay.classList.add("opacity-0");
                panel.classList.add("translate-x-full");
                setTimeout(() => {
                    drawer.classList.add("hidden");
                }, 500);
            }
        }


        function reloadCart() {
            fetch("{{ route('frontend.inventory') }}?cart=1")
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");


                    document.getElementById("cart-items").innerHTML =
                        doc.querySelector("#cart-items").innerHTML;


                    const newTotal = doc.querySelector("#cart-total").innerText;
                    const footerTotal = document.getElementById("cart-total");
                    if (footerTotal) {
                        footerTotal.innerText = newTotal;
                    }


                    const newHeaderCount = doc.querySelector("#drawer-count").innerText;
                    const headerCountElement = document.getElementById("drawer-count");
                    if (headerCountElement) {
                        headerCountElement.innerText = newHeaderCount;
                    }
                });
        }


        function checkCartButton(totalQty) {
            let btnEmpty = document.getElementById('btn-empty');
            let btnFilled = document.getElementById('btn-filled');

            if (btnEmpty && btnFilled) {
                if (totalQty > 0) {
                    btnEmpty.classList.add('hidden');
                    btnFilled.classList.remove('hidden');
                } else {
                    btnEmpty.classList.remove('hidden');
                    btnFilled.classList.add('hidden');
                }
            }
        }

        function addToCart(id) {
            fetch("/inventory/cart/add/" + id, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    reloadCart();
                    toggleCart();

                    if (data.total !== undefined) {
                        updateFloatingBadge(data.total);
                        checkCartButton(data.total);
                    }
                })
                .catch(err => console.error("Error:", err));
        }

        function updateQty(id, qty) {
            fetch("/inventory/cart/update-qty", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id,
                        qty
                    })
                })
                .then(res => res.json())
                .then(data => {
                    reloadCart();

                    if (data.total !== undefined) {
                        updateFloatingBadge(data.total);
                        checkCartButton(data.total);
                    }
                })
                .catch(err => console.error("Error:", err));
        }

        function removeItem(id) {
            fetch("/inventory/cart/remove/" + id, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    reloadCart();

                    if (data.total !== undefined) {
                        updateFloatingBadge(data.total);
                        checkCartButton(data.total);
                    }
                });
        }
    </script>
    <script>
        let searchTimer = null;

        function autoSearch(element) {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(() => {
                element.form.submit();
            }, 800);
        }
    </script>
@endsection
