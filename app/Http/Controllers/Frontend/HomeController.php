<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Article;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {

        $showCompleteProfileModal = false;

        // USER LOGIN
        if (auth()->guard('web')->check()) {

            $user = auth()->guard('web')->user();

            if (
                empty($user->full_name) ||
                empty($user->email) ||
                empty($user->phone_number)
            ) {

                $showCompleteProfileModal = true;
            }
        }

        // OPA LOGIN
        if (auth()->guard('opa')->check()) {

            $opa = auth()->guard('opa')->user();

            if (
                empty($opa->name) ||
                empty($opa->email) ||
                empty($opa->organization_name) ||
                empty($opa->campus_name) ||
                empty($opa->phone_number)
            ) {

                $showCompleteProfileModal = true;
            }
        }

        $inventoryItems = Item::with('category')->orderBy('id', 'desc')->take(5)->get();

        $articles = Article::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $activities = Activity::with('members')
            ->where('start_date', '>=', Carbon::now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        return view('frontend.home.index', compact('inventoryItems', 'activities', 'articles', 'showCompleteProfileModal'));
    }

    public function contact()
    {
        return view('frontend.contact.index');
    }

    public function aboutUs()
    {
        return view('frontend.about.index');
    }

    public function send(Request $request)
    {
        $data = $request->all();

        Mail::send([], [], function ($message) use ($data) {
            $message->to('logistiktarantula@gmail.com') // GANTI EMAIL TUJUAN
                ->subject($data['subject'])
                ->html("
                    <h3>Pesan Baru</h3>
                    <p><b>Nama:</b> {$data['name']}</p>
                    <p><b>Email:</b> {$data['email']}</p>
                    <p><b>Pesan:</b><br>{$data['message']}</p>
                ");
        });

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
