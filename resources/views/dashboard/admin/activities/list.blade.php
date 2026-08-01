@extends('dashboard.layouts.app')

@section('content')
    <div class="mb-5 flex justify-end">
        @if (session('success'))
            <x-alert-success title="Berhasil!" :message="session('success')" />
        @endif
    </div>

    <x-breadcrumb :items="[
        ['label' => 'Kegiatan', 'url' => route('list.activity')],
        ['label' => 'Daftar Kegiatan', 'url' => route('list.activity')],
    ]" />

    <div x-data="{ showFilter: false }">

        <div
            class="bg-white border border-[#E0E0E0] rounded-xl h-auto p-4 overflow-hidden px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/3 sm:px-6s">
            <h3 class="font-bold text-2xl text-gray-800 dark:text-white/90 mb-6">Daftar Kegiatan</h3>

            <div class="flex justify-between items-center my-2">
                {{-- Search --}}
                <div class="hidden lg:max-w-[430px] md:block">
                    <div class="relative">
                        <span class="absolute top-1/2 left-4 -translate-y-1/2">
                            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Search" id="search-input"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-[#7653afaa] focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-sm rounded-lg border-2 border-gray-300 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-800 dark:bg-white/3 dark:text-white/90 dark:placeholder:text-white/30" />
                    </div>
                </div>

                {{-- Filter & Tambah --}}
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 text-xs">
                        <span class="dark:text-white">Showing</span>

                        <div class="relative">
                            <select id="perPageSelect" name="perPage"
                                class="appearance-none border border-gray-300 rounded-lg ps-3 pe-8 py-2.5 focus:outline-hidden dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/3 dark:hover:text-gray-200 dark:focus:bg-gray-800 text-sm">
                                <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                            </select>
                            <img src="{{ asset('assets/images/icons/chevron-down.svg') }}" alt="arrow light"
                                class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 opacity-70 block dark:hidden">
                            <img src="{{ asset('assets/images/icons/chevron-down-dark.svg') }}" alt="arrow dark"
                                class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 opacity-80 hidden dark:block">
                        </div>
                    </div>

                    <!-- Tombol Filter -->
                    <button @click="showFilter = !showFilter" type="button"
                        :class="showFilter
                            ?
                            'bg-[#7653afaa] text-white border-0 dark:bg-[#7653afaa] dark:border-[#7653afaa] dark:text-white' :
                            'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 hover:text-gray-800 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700 dark:hover:bg-white/3 dark:hover:text-gray-200'"
                        class="hidden md:inline-flex items-center gap-2 border rounded-lg px-4 py-2.5 text-sm font-medium shadow-theme-xs transition">

                        <!-- Icon saat tidak aktif -->
                        <img x-show="!showFilter" src="{{ asset('assets/images/icons/funnell.svg') }}"
                            alt="Filter Icon Light" class="w-4 h-4 opacity-70 block dark:hidden">
                        <img x-show="!showFilter" src="{{ asset('assets/images/icons/funnel-darkk.svg') }}"
                            alt="Filter Icon Dark" class="w-4 h-4 opacity-80 hidden dark:block">

                        <!-- Icon saat aktif -->
                        <img x-show="showFilter" src="{{ asset('assets/images/icons/funnell-dark.svg') }}"
                            alt="Filter Icon Active Light" class="w-4 h-4 opacity-90 block">

                        <span class="text-sm font-medium">Filter</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div x-show="showFilter" x-transition
            class="mt-2 overflow-hidden rounded-xl border border-[#E0E0E0] bg-white p-4 dark:border-gray-800 dark:bg-white/5 sm:px-6">

            <div class="flex flex-wrap items-end gap-5">

                <!-- Jenis Kegiatan -->
                <div class="hs-dropdown relative [--auto-close:inside]">
                    <div class="flex flex-col">
                        <span class="mb-1 text-sm font-medium dark:text-white">
                            Jenis Kegiatan
                        </span>

                        <button id="typeDropdownBtn" type="button"
                            class="hs-dropdown-toggle inline-flex w-64 items-center justify-between gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-normal text-gray-800 shadow-2xs transition focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">

                            {{ ucfirst(request('type', 'Semua Jenis Kegiatan')) }}

                            <svg class="size-4 hs-dropdown-open:rotate-180" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                            </svg>
                        </button>
                    </div>

                    <div class="hs-dropdown-menu mt-2 hidden min-w-60 rounded-lg bg-white opacity-0 shadow-md transition-[opacity,margin] duration-200 hs-dropdown-open:opacity-100 dark:divide-gray-700 dark:border dark:border-gray-700 dark:bg-gray-800"
                        role="menu" aria-orientation="vertical" aria-labelledby="typeDropdownBtn">

                        <div class="space-y-0.5 p-1">

                            <button type="button" data-value="all"
                                class="type-option flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Semua Jenis Kegiatan
                            </button>

                            <button type="button" data-value="meeting"
                                class="type-option flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Rapat
                            </button>

                            <button type="button" data-value="basic training"
                                class="type-option flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Diksar
                            </button>

                            <button type="button" data-value="exploration"
                                class="type-option flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Pengembaraan
                            </button>

                            <button type="button" data-value="anniversary"
                                class="type-option flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Hari Jadi
                            </button>

                            <button type="button" data-value="others"
                                class="type-option flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Lain-lain
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Reset -->
                <button id="resetFiltersBtn"
                    class="inline-flex h-11 items-center gap-2 rounded-xl border border-gray-300 bg-gray-100 px-5 text-sm font-medium text-gray-700 shadow-sm transition-all duration-300 hover:bg-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">

                    <img src="{{ asset('assets/images/icons/rotate-cw.svg') }}" alt="Reset"
                        class="block h-4 w-4 dark:hidden">

                    <img src="{{ asset('assets/images/icons/rotate-cw-dark.svg') }}" alt="Reset"
                        class="hidden h-4 w-4 dark:block">

                    <span>Reset</span>
                </button>

                <!-- Export -->
                <a href="#" id="exportBtn"
                    class="inline-flex h-11 items-center gap-2 rounded-xl border-2 border-[#7EE2A8] bg-white px-5 text-sm font-medium text-[#22C55E] shadow-sm transition-all duration-300 hover:bg-[#F0FFF5] dark:border-green-500 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700">

                    <img src="{{ asset('assets/images/icons/logo-excel.png') }}" alt="Excel" class="h-4 w-4">

                    <span>Export</span>
                </a>

            </div>
        </div>

    </div>

    <div
        class="bg-white border border-[#E0E0E0] rounded-xl h-auto p-4 overflow-hidden px-4 mt-3.5 pb-3 pt-4 dark:border-gray-800 dark:bg-white/3 sm:px-6s">
        <div class="w-full overflow-x-auto">
            <div id="activity-table">
                @include('dashboard.admin.activities.partials.table')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.querySelector("#search-input");
            const tableContainer = document.querySelector("#activity-table");
            const perPageSelect = document.querySelector("#perPageSelect");

            const typeButtons = document.querySelectorAll(".type-option");
            const typeBtnLabel = document.querySelector("#typeDropdownBtn");

            const resetBtn = document.querySelector("#resetFiltersBtn");

            const exportBtn = document.querySelector("#exportBtn");

            let searchTimeout = null;

            let currentType = "{{ request('type', 'all') }}";

            // =========================
            // UPDATE EXPORT URL
            // =========================
            function updateExportUrl() {

                const params = new URLSearchParams();

                if (searchInput.value) {
                    params.set("search", searchInput.value);
                }

                if (currentType !== "all") {
                    params.set("type", currentType);
                }

                exportBtn.href =
                    `{{ route('activities.export') }}?${params.toString()}`;
            }

            // =========================
            // FETCH DATA AJAX
            // =========================
            async function fetchData(url = "{{ route('list.activity') }}") {

                const params = new URLSearchParams({
                    search: searchInput.value,
                    perPage: perPageSelect.value,
                    type: currentType,
                });

                if (url.includes("?")) {

                    const baseUrl = url.split("?")[0];

                    const existingParams = new URLSearchParams(
                        url.split("?")[1]
                    );

                    existingParams.set("search", searchInput.value);
                    existingParams.set("perPage", perPageSelect.value);
                    existingParams.set("type", currentType);

                    url = `${baseUrl}?${existingParams.toString()}`;

                } else {

                    url = `${url}?${params.toString()}`;
                }

                const response = await fetch(url, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });

                const html = await response.text();

                tableContainer.innerHTML = html;

                // Re-init component
                if (window.HSStaticMethods) {
                    window.HSStaticMethods.autoInit();
                }

                // Re-init delete form
                initDeleteForms();

                // Update export URL
                updateExportUrl();
            }

            // =========================
            // DELETE FORM
            // =========================
            function initDeleteForms() {

                const deleteForms = document.querySelectorAll(
                    "form.btn-delete"
                );

                deleteForms.forEach(form => {

                    form.addEventListener("submit", function(e) {

                        const confirmed = confirm(
                            "Yakin ingin menghapus data ini?"
                        );

                        if (!confirmed) {
                            e.preventDefault();
                        }
                    });
                });
            }

            // Jalankan sekali di awal
            initDeleteForms();

            // =========================
            // SEARCH
            // =========================
            searchInput.addEventListener("input", function() {

                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {

                    fetchData();

                }, 300);
            });

            // =========================
            // PER PAGE
            // =========================
            perPageSelect.addEventListener("change", function() {

                fetchData();
            });

            // =========================
            // FILTER TYPE
            // =========================
            typeButtons.forEach(btn => {

                btn.addEventListener("click", function() {

                    currentType = this.dataset.value;

                    typeBtnLabel.innerHTML = this.textContent + `
                <svg class='hs-dropdown-open:rotate-180 size-4'
                    xmlns='http://www.w3.org/2000/svg'
                    width='24'
                    height='24'
                    viewBox='0 0 24 24'
                    fill='none'
                    stroke='currentColor'
                    stroke-width='2'
                    stroke-linecap='round'
                    stroke-linejoin='round'>
                    <path d='m6 9 6 6 6-6'/>
                </svg>`;

                    fetchData();
                });
            });

            // =========================
            // PAGINATION AJAX
            // =========================
            document.addEventListener("click", function(e) {

                const link = e.target.closest(".pagination a");

                if (link) {

                    e.preventDefault();

                    fetchData(link.getAttribute("href"));
                }
            });

            // =========================
            // RESET FILTER
            // =========================
            resetBtn.addEventListener("click", function() {

                currentType = "all";

                searchInput.value = "";

                typeBtnLabel.innerHTML = `
                Semua Jenis Kegiatan
                <svg class='hs-dropdown-open:rotate-180 size-4'
                    xmlns='http://www.w3.org/2000/svg'
                    width='24'
                    height='24'
                    viewBox='0 0 24 24'
                    fill='none'
                    stroke='currentColor'
                    stroke-width='2'
                    stroke-linecap='round'
                    stroke-linejoin='round'>
                    <path d='m6 9 6 6 6-6'/>
                </svg>`;

                fetchData();
            });

            // =========================
            // INIT EXPORT URL
            // =========================
            updateExportUrl();

        });
    </script>
@endsection
