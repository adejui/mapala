<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('category');


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }


        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'Terlama':
                    $query->orderBy('id', 'asc');
                    break;
                case 'A-Z':
                    $query->orderBy('name', 'asc');
                    break;
                case 'Terbaru':
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $items = $query->paginate(10)->withQueryString();

        $categories = Category::all();

        return view('frontend.inventory.index', compact('items', 'categories'));
    }

    public function show($id)
    {
        // Ambil data alat berdasarkan ID
        $item = Item::findOrFail($id);

        // Ambil rekomendasi (opsional)
        $relatedItems = Item::with(['photos', 'category'])
            ->where('id', '!=', $id)
            ->where('category_id', $item->category_id)
            ->orderByDesc('quantity') // yang stoknya banyak duluan
            ->take(5)
            ->get();

        // Kirim ke view
        return view('frontend.inventory.show', compact('item', 'relatedItems'));
    }

    public function addToCart($id)
    {
        $item = Item::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                'id' => $item->id,
                'name' => $item->name,
                'code' => $item->code,
                'category' => $item->category->name ?? 'Umum',
                'photo' => $item->photo,
                'qty' => 1,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'total' => collect(session('cart', []))->sum('qty')
        ]);
    }

    // public function updateQty(Request $request)
    // {
    //     $id = $request->id;
    //     $qty = $request->qty;

    //     $cart = session()->get('cart', []);

    //     if (isset($cart[$id])) {

    //         // Kalau qty < 1, hapus item
    //         if ($qty < 1) {
    //             unset($cart[$id]);
    //         } else {
    //             $cart[$id]['qty'] = $qty;
    //         }

    //         session()->put('cart', $cart);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'total' => collect(session('cart', []))->sum('qty')
    //     ]);
    // }

    public function updateQty(Request $request)
    {
        $id = $request->id;
        $qty = (int) $request->qty;

        $cart = session()->get('cart', []);

        // Ambil item dari database
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ]);
        }

        if (isset($cart[$id])) {

            // Kalau qty < 1 → hapus
            if ($qty < 1) {
                unset($cart[$id]);
            } else {

                // BATASI SESUAI STOK
                if ($qty > $item->quantity) {
                    $qty = $item->quantity;
                }

                $cart[$id]['qty'] = $qty;
            }

            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'qty' => $cart[$id]['qty'] ?? 0,
            'total' => collect(session('cart', []))->sum('qty'),
            'message' => $qty > $item->quantity ? 'Qty melebihi stok, disesuaikan' : null
        ]);
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = max(1, $request->qty);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'total' => collect(session('cart', []))->sum('qty')
        ]);
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'total' => collect(session('cart', []))->sum('qty')
        ]);
    }
}
