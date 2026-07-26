<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PublicArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(5);

        $popular_articles = Article::where('status', 'published')
            ->where('id', '!=', $article->id ?? null)
            ->orderByDesc('views')
            ->take(4)
            ->get();

        return view('frontend.articles.index', compact('articles', 'popular_articles'));
    }

    public function show($slug)
    {

        $article = Article::where('slug', $slug)->firstOrFail();

        // tambah view
        $article->increment('views');

        // Ambil related berdasarkan activity_type
        $related_articles = Article::whereHas('activity', function ($query) use ($article) {
            $query->where('activity_type', $article->activity->activity_type);
        })
            ->where('id', '!=', $article->id) // biar tidak termasuk artikel yang sama
            ->latest()
            ->take(6)
            ->get();

        // Kalau tidak ada related, ambil terbaru umum
        if ($related_articles->count() < 1) {
            $related_articles = Article::where('id', '!=', $article->id)
                ->latest()
                ->take(4)
                ->get();
        }

        return view('frontend.articles.detail', compact('article', 'related_articles'));
    }
}
