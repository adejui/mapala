<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Mengambil semua item yang ada di database untuk mendapatkan ID dan Namanya
        $items = Item::all();
        $photoData = [];

        foreach ($items as $item) {
            // Mengubah nama alat menjadi huruf kecil semua dan menghapus semua spasi
            // Contoh: "Tabung Gas Portable" menjadi "tabunggasportable"
            $cleanName = str_replace(' ', '', strtolower($item->name));

            // Membuat 4 data foto untuk setiap 1 alat
            for ($i = 1; $i <= 4; $i++) {
                $photoData[] = [
                    'item_id' => $item->id,
                    // Format path: contoh_folder/tabunggasportable-1.png
                    'photo_path' => "items/{$cleanName}-{$i}.png",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data foto sekaligus (Bulk Insert) agar performanya cepat
        if (!empty($photoData)) {
            DB::table('item_photos')->insert($photoData);
        }
    }

    // public function run(): void
    // {
    //     // Ambil semua file foto di storage/app/public/items
    //     $photoFiles = [
    //         'items/product-01.jpg',
    //         'items/product-02.jpg',
    //         'items/product-03.jpg',
    //         'items/product-04.jpg',
    //         'items/product-05.jpg',
    //     ];

    //     $data = [];

    //     // Misal setiap item (1–10) punya 1–3 foto acak
    //     for ($itemId = 1; $itemId <= 10; $itemId++) {
    //         $photoCount = rand(1, 3);

    //         for ($i = 0; $i < $photoCount; $i++) {
    //             $data[] = [
    //                 'item_id' => $itemId,
    //                 'photo_path' => 'storage/' . Arr::random($photoFiles),
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }
    //     }

    //     ItemPhoto::insert($data);
    // }
}
