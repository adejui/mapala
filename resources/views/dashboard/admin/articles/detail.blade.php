@extends('dashboard.layouts.app')

@section('content')
    <x-breadcrumb :items="[['label' => 'Artikel', 'url' => route('articles.index')], ['label' => 'Detail Artikel']]" />


    <div
        class="bg-white border border-[#E0E0E0] rounded-xl h-auto p-4 overflow-hidden px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/3 sm:px-6s">
        <h3 class="font-bold text-2xl text-gray-800 dark:text-white/90 mb-6">Detail Artikel</h3>

        <div class="flex items-center justify-end mb-1">
            <p class="text-[#2E2E2E] text-theme-sm dark:text-gray-400">
                <x-status-badge :status="$article->status" />
            </p>
        </div>

        <!-- THUMBNAIL -->
        <div class="rounded-xl dark:border-gray-700 h-fit dark:bg-white/5 flex flex-col items-center">
            <div class="w-full">
                @if ($article->file_path)
                    <img src="{{ Storage::url($article->file_path) }}" alt="Foto {{ $article->full_name }}"
                        class="h-72 w-full object-cover rounded-3xl" />
                @else
                    <p></p>
                @endif
            </div>
        </div>

        <div class="flex justify-between my-2 mx-4 dark:text-white/90">
            <div class="text-xs">
                {{ $article->activity->title ?? '' }}
            </div>
            <div class="text-xs">
                {{ $article->created_at->translatedFormat('l, d F Y') ?? '' }}
            </div>
        </div>

        <div class="text-4xl font-bold dark:text-white/90">
            {{ $article->title ?? '' }}
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
        <div class="my-3 text-sm dark:text-white/90 my-content">
            {!! $article->content ?? '' !!}
        </div>

    </div>
@endsection
