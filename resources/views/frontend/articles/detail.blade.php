@extends('frontend.layouts.app')

@section('content')
    <div class="bg-white min-h-screen pt-32 pb-20 px-6 md:px-16">
        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Artikel</h1>
                <nav class="flex text-sm font-medium text-gray-500">
                    <a href="{{ route('frontend.home') }}" class="transition-colors">Home</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('frontend.artikel') }}" class="transition-colors">Artikel</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('frontend.artikel.show', $article->slug) }}"
                        class="text-[#7C3AED] transition-colors">Detail
                        Artikel</a>
                </nav>
            </div>


            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">


                <div class="lg:col-span-8 space-y-20">

                    <article class="flex flex-col">
                        <h2
                            class="text-3xl mb-2.5 md:text-4xl font-bold text-center text-gray-900 leading-snug hover:text-[#7C3AED] transition-colors cursor-pointer">
                            {{ $article->title }}
                        </h2>

                        <div class="w-full mx-auto aspect-[16/9] rounded-3xl overflow-hidden shadow-sm">
                            <img src="{{ $article->file_path ? asset('storage/' . $article->file_path) : asset('assets/images/articles/default-image.png') }}"
                                alt="Diksar Mapala"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>

                        <div class="flex mt-2 justify-between text-sm text-gray-500 font-medium">
                            <div>
                                {{ $article->activity->title ?? '' }}
                            </div>
                            <div>
                                <span>Admin Mapala</span>
                                <span class="mx-3">•</span>
                                <span>{{ explode(',', $article->activity->location ?? '')[0] }}</span>
                                <span>,
                                    {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>


                        <style>
                            .my-content ol {
                                list-style: decimal !important;
                                padding-left: 24px !important;
                                margin-left: 16px !important;
                            }

                            .my-content ul {
                                list-style: disc !important;
                                padding-left: 44px !important;
                                margin-left: 16px !important;
                            }

                            .my-content ol ol,
                            .my-content ul ul,
                            .my-content ol ul,
                            .my-content ul ol {
                                margin-left: 20px !important;
                            }
                        </style>
                        <div class="text-gray-600 text-justify my-content mt-5">
                            {!! $article->content !!}
                        </div>
                    </article>

                </div>


                <div class="lg:col-span-4">
                    <div class="sticky top-32">

                        <h3 class="text-2xl font-bold text-gray-900 mb-8">Artikel Terkait</h3>

                        <div class="space-y-8">
                            @foreach ($related_articles as $item)
                                <a href="{{ route('frontend.artikel.show', $item->slug) }}"
                                    class="group flex gap-5 items-start">

                                    <div class="w-28 h-28 flex-shrink-0 rounded-2xl overflow-hidden shadow-sm">
                                        <img src="{{ $item->file_path ? asset('storage/' . $item->file_path) : asset('assets/images/articles/default-image.png') }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <h4
                                            class="text-base font-bold text-gray-900 leading-snug line-clamp-3 group-hover:text-[#7C3AED] transition-colors">
                                            {{ $item->title }}
                                        </h4>

                                        <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                            {{-- <i class="fa-regular fa-clock"></i> --}}
                                            <i class="fa-regular fa-calendar"></i>
                                            <span>
                                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}
                                            </span>
                                            {{-- <span>{{ $item->created_at->diffForHumans() }}</span> --}}
                                        </div>
                                    </div>

                                </a>
                            @endforeach
                        </div>

                    </div>
                </div>


            </div>



        </div>
    </div>
@endsection
