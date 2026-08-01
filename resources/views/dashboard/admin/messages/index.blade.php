@extends('dashboard.layouts.app')

@section('content')
    <div class="mb-5 flex justify-end">
        @if (session('success'))
            <x-alert-success title="Berhasil!" :message="session('success')" />
        @endif
    </div>

    <x-breadcrumb :items="[
        ['label' => 'Pesan', 'url' => route('messages.index')],
        ['label' => 'Daftar Pesan', 'url' => route('messages.index')],
    ]" />

    <div x-data="messageHandler()">
        <div
            class="bg-white border border-[#E0E0E0] rounded-xl p-5 overflow-hidden
           dark:bg-gray-900 dark:border-gray-700 dark:shadow-xl">

            <h3 class="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">
                Daftar Pesan
            </h3>

            <div class="flex flex-wrap items-center justify-between gap-4">

                <!-- KIRI -->
                <div class="flex items-center gap-3">

                    <!-- Search -->
                    <div class="hidden md:block">
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2">
                                <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20"
                                    viewBox="0 0 20 20" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" />
                                </svg>
                            </span>

                            <input type="text" id="search-input" placeholder="Search"
                                class="h-11 w-80 rounded-xl border-2 border-gray-300 bg-white
                               pl-12 pr-4 text-sm text-gray-700
                               placeholder:text-gray-400
                               focus:border-[#7653AF] focus:outline-none

                               dark:border-gray-700
                               dark:bg-gray-800
                               dark:text-gray-100
                               dark:placeholder:text-gray-500">
                        </div>
                    </div>

                    <!-- Filter Status -->
                    <div class="relative">
                        <select id="statusSelect"
                            class="h-11 appearance-none rounded-xl border border-gray-300
                               bg-white ps-3 pe-8 text-sm
                               dark:border-gray-700
                               dark:bg-gray-800
                               dark:text-white">
                            <option value="">Semua Status</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Belum Dibaca
                            </option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                        </select>

                        <img src="{{ asset('assets/images/icons/chevron-down.svg') }}"
                            class="pointer-events-none absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 block dark:hidden">

                        <img src="{{ asset('assets/images/icons/chevron-down-dark.svg') }}"
                            class="pointer-events-none absolute right-2 top-1/2 hidden h-4 w-4 -translate-y-1/2 dark:block">
                    </div>

                    <!-- Export -->
                    <a href="{{ route('messages.export') }}" id="export-link"
                        class="inline-flex h-11 items-center gap-2 rounded-xl
                       border-2 border-[#7EE2A8]
                       bg-white px-5
                       text-sm font-medium text-[#22C55E]
                       shadow-sm transition-all duration-300
                       hover:bg-[#F0FFF5] hover:shadow-md

                       dark:border-[#22C55E]
                       dark:bg-gray-900
                       dark:text-[#4ADE80]
                       dark:hover:bg-gray-800">

                        <img src="{{ asset('assets/images/icons/logo-excel.png') }}" class="h-4 w-4" alt="Excel">

                        <span>Export</span>
                    </a>

                </div>

                <!-- KANAN -->
                <div class="flex items-center gap-3">

                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600 dark:text-gray-300">
                            Showing
                        </span>

                        <div class="relative">
                            <select id="perPageSelect"
                                class="h-11 appearance-none rounded-xl border border-gray-300
                               bg-white ps-3 pe-8 text-sm
                               dark:border-gray-700
                               dark:bg-gray-800
                               dark:text-white">

                                <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                            </select>

                            <img src="{{ asset('assets/images/icons/chevron-down.svg') }}"
                                class="pointer-events-none absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 block dark:hidden">

                            <img src="{{ asset('assets/images/icons/chevron-down-dark.svg') }}"
                                class="pointer-events-none absolute right-2 top-1/2 hidden h-4 w-4 -translate-y-1/2 dark:block">
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div
            class="bg-white border border-[#E0E0E0] rounded-xl h-auto p-4 overflow-hidden px-4 mt-3.5 pb-3 pt-4 dark:border-gray-800 dark:bg-white/3 sm:px-6s">
            <div class="w-full overflow-x-auto">
                <div id="message-table">
                    @include('dashboard.admin.messages.partials.table')
                </div>
            </div>
        </div>

        <!-- Modal Detail Pesan -->
        <template x-teleport="body">
            <div x-cloak x-show="showDetail" class="fixed inset-0 z-50 flex items-center justify-end">
                <div class="absolute inset-0 bg-black/50" @click="showDetail = false"></div>

                <div x-show="showDetail" x-transition:enter="transform transition ease-in-out duration-500"
                    x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                    class="relative mr-8 z-50 bg-white dark:bg-gray-800 w-full sm:w-[500px] h-fit shadow-2xl border-l border-gray-200 dark:border-neutral-700 p-6 overflow-y-auto rounded-2xl">

                    <div class="flex justify-between items-center pb-3 mb-4">
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                            Detail Pesan
                        </h2>
                        <button @click="showDetail = false"
                            class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-[#616161] font-medium text-xs mb-1 block dark:text-gray-400">Nama</label>
                            <p class="text-sm text-gray-800 dark:text-white" x-text="selectedMessage.name"></p>
                        </div>

                        <div>
                            <label class="text-[#616161] font-medium text-xs mb-1 block dark:text-gray-400">Email</label>
                            <p class="text-sm text-gray-800 dark:text-white" x-text="selectedMessage.email"></p>
                        </div>

                        <div>
                            <label class="text-[#616161] font-medium text-xs mb-1 block dark:text-gray-400">Subjek</label>
                            <p class="text-sm text-gray-800 dark:text-white" x-text="selectedMessage.subject"></p>
                        </div>

                        <div>
                            <label class="text-[#616161] font-medium text-xs mb-1 block dark:text-gray-400">Pesan</label>
                            <p class="text-sm text-gray-800 dark:text-white whitespace-pre-line"
                                x-text="selectedMessage.message"></p>
                        </div>
                    </div>

                    <div class="flex justify-end items-center w-full mt-8">
                        <button type="button" @click="showDetail = false"
                            class="p-2 border-2 text-sm dark:text-white border-[#7753AF] bg-transparent w-full rounded-lg text-[#7753AF] text-center dark:hover:bg-gray-800 hover:bg-[#F3E8FF] transition">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </template>
    </div>

    <script>
        function messageHandler() {
            return {
                showDetail: false,
                selectedMessage: {
                    id: '',
                    name: '',
                    email: '',
                    subject: '',
                    message: '',
                    status: 'unread'
                },

                openDetail(message) {
                    this.selectedMessage = {
                        ...message
                    };
                    this.showDetail = true;

                    if (message.status === 'unread') {
                        const url = `{{ route('messages.markAsRead', ':id') }}`.replace(':id', message.id);

                        fetch(url, {
                                method: 'PATCH',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content')
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`Gagal update status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                this.selectedMessage.status = data.status;

                                const badge = document.querySelector(`#status-badge-${message.id}`);
                                if (badge) {
                                    badge.textContent = 'Sudah Dibaca';
                                    badge.classList.remove('bg-red-100', 'text-red-600', 'dark:bg-red-900/30',
                                        'dark:text-red-400');
                                    badge.classList.add('bg-green-100', 'text-green-600', 'dark:bg-green-900/30',
                                        'dark:text-green-400');
                                }
                            })
                            .catch(error => {
                                console.error('Mark as read gagal:', error);
                            });
                    }
                }
            };
        }
    </script>

    {{-- Table search, filter, and pagination --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector("#search-input");
            const perPageSelect = document.querySelector("#perPageSelect");
            const statusSelect = document.querySelector("#statusSelect");
            const tableContainer = document.querySelector("#message-table");
            const exportLink = document.querySelector("#export-link");
            const baseExportUrl = "{{ route('messages.export') }}";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let searchTimeout = null;
            // simpan halaman aktif supaya tidak hilang saat search/perPage dipakai bersamaan
            let currentPage = null;

            async function fetchData(url = "{{ route('messages.index') }}", resetPage = false) {
                if (resetPage) currentPage = null;

                // ambil query string yang sudah ada di url (misalnya ?page=2)
                let baseUrl = url;
                let existingParams = new URLSearchParams();

                if (url.includes("?")) {
                    const parts = url.split("?");
                    baseUrl = parts[0];
                    existingParams = new URLSearchParams(parts[1]);
                }

                // timpa/tambahkan filter terkini
                existingParams.set("search", searchInput.value);
                existingParams.set("perPage", perPageSelect.value);
                existingParams.set("status", statusSelect.value);

                // kalau reset (search/perPage/status berubah), jangan bawa page lama
                if (resetPage) {
                    existingParams.delete("page");
                } else if (existingParams.has("page")) {
                    currentPage = existingParams.get("page");
                }

                const finalUrl = `${baseUrl}?${existingParams.toString()}`;

                try {
                    const response = await fetch(finalUrl, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": csrfToken
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`Gagal memuat data: ${response.status}`);
                    }

                    const html = await response.text();
                    tableContainer.innerHTML = html;

                    if (window.HSStaticMethods) {
                        window.HSStaticMethods.autoInit();
                    }

                    // Update export link tiap kali data ter-fetch ulang
                    updateExportLink();
                } catch (error) {
                    console.error("Fetch data gagal:", error);
                }
            }

            // Update href tombol Export supaya ikut membawa filter search & status aktif
            function updateExportLink() {
                if (!exportLink) return;
                const params = new URLSearchParams();

                if (searchInput.value) {
                    params.set("search", searchInput.value);
                }

                if (statusSelect.value) {
                    params.set("status", statusSelect.value);
                }

                exportLink.setAttribute("href", `${baseExportUrl}?${params.toString()}`);
            }

            // Search (debounce, reset ke halaman 1)
            searchInput.addEventListener("input", function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    fetchData(undefined, true);
                }, 300);
            });

            // Ganti jumlah data per halaman (reset ke halaman 1)
            perPageSelect.addEventListener("change", function() {
                fetchData(undefined, true);
            });

            // Ganti filter status (reset ke halaman 1)
            statusSelect.addEventListener("change", function() {
                fetchData(undefined, true);
            });

            // set href export sesuai kondisi awal (misal reload halaman dengan query string)
            updateExportLink();

            // Klik link pagination (event delegation, di-scope ke #message-table
            // supaya tidak salah tangkap link lain di halaman)
            tableContainer.addEventListener("click", function(e) {
                const link = e.target.closest("nav a, .pagination a, ul.pagination a");
                if (!link) return;

                const href = link.getAttribute("href");
                // abaikan link disabled ("#" atau kosong)
                if (!href || href === "#") {
                    e.preventDefault();
                    return;
                }

                e.preventDefault();
                fetchData(href, false);
            });
        });
    </script>
@endsection
