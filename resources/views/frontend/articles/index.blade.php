@extends('frontend.layouts.app')

@section('content')
    <div class="bg-white min-h-screen pt-32 pb-20 px-6 md:px-16">
        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Artikel</h1>
                <nav class="flex text-sm font-medium text-gray-500">
                    <a href="{{ route('frontend.home') }}" class="transition-colors">Home</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('frontend.artikel') }}" class="text-[#7C3AED] transition-colors">Artikel</a>
                </nav>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <div class="lg:col-span-8 space-y-20">

                    @forelse ($articles as $item)
                        <article class="grid grid-cols-4 gap-6 mb-10">

                            <div class="col-span-3">
                                <a href="{{ route('frontend.artikel.show', $item->slug) }}">
                                    <h2
                                        class="text-2xl md:text-2xl font-bold text-gray-900 leading-snug hover:text-[#7C3AED] transition-colors">
                                        {{ $item->title }}
                                    </h2>
                                </a>

                                <div class="flex items-center text-sm text-gray-500 font-medium mt-2">
                                    <span>
                                        {{ [
                                            'meeting' => 'Rapat',
                                            'basic training' => 'Pendidikan Dasar',
                                            'exploration' => 'Eksplorasi',
                                            'anniversary' => 'Hari Jadi',
                                            'others' => 'Lainnya',
                                        ][$item->activity->activity_type ?? ''] ?? '' }}
                                    </span>
                                    <span class="mx-3">•</span>
                                    <span>
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <div class="w-40 h-auto flex-shrink-0 rounded-2xl overflow-hidden shadow-sm">
                                    <img src="{{ $item->file_path ? asset('storage/' . $item->file_path) : asset('assets/images/articles/default-image.png') }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                            </div>

                        </article>
                    @empty
                        <article class="flex flex-col gap-6">
                            <h2
                                class="text-5xl md:text-5xl font-bold text-gray-900 leading-snug hover:text-[#7C3AED] transition-colors cursor-pointer">
                                Belum Ada Artikel.
                            </h2>
                        </article>
                    @endforelse

                    <div class="pt-8">
                        {{ $articles->links('vendor.pagination.tailwind-artikel') }}
                    </div>

                </div>

                <div class="lg:col-span-4">
                    <div class="sticky top-32">

                        <h3 class="text-2xl font-bold text-gray-900 mb-5">Artikel Terpopuler</h3>

                        <div class="space-y-8 border border-gray-400 p-6 rounded-3xl">

                            @forelse ($popular_articles as $item)
                                <a href="{{ route('frontend.artikel.show', $item->slug) }}"
                                    class="group flex gap-5 items-start">
                                    <div class="flex flex-col gap-2">
                                        <h4
                                            class="text-base font-bold text-gray-900 leading-snug line-clamp-3 group-hover:text-[#7C3AED] transition-colors">
                                            {{ $item->title }}
                                        </h4>
                                        <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                            <i class="fa-regular fa-eye"></i>
                                            <span>{{ $item->views }} kali dibaca</span>
                                        </div>
                                    </div>
                                    <div class="w-28 h-auto flex-shrink-0 rounded-2xl overflow-hidden shadow-sm">
                                        <img src="{{ $item->file_path ? asset('storage/' . $item->file_path) : asset('assets/images/articles/default-image.png') }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                </a>
                            @empty
                                <h4
                                    class="text-base font-bold text-gray-900 leading-snug line-clamp-3 group-hover:text-[#7C3AED] transition-colors">
                                    Belum ada artikel.
                                </h4>
                            @endforelse
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
