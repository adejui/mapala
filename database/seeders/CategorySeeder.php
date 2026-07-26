<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['id' => 1, 'name' => 'Peralatan Camping & Logistik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Peralatan Memasak', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Navigasi & Diklat', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Mountaineering & RC', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Inventaris Sekretariat & Umum', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
