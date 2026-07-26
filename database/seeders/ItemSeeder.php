<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::insert([
            // ==========================================
            // KATEGORI 5: INVENTARIS SEKRETARIAT & UMUM
            // ==========================================
            [
                'category_id' => 5,
                'name' => 'Speaker',
                'code' => 'GEN-009',
                'quantity' => 1,
                'description' => '1 Set Sound System Sekre.',
            ],
            [
                'category_id' => 5,
                'name' => 'Lemari',
                'code' => 'GEN-008',
                'quantity' => 3,
                'description' => 'Penyimpanan sekre: 2 Bahan Plastik, 1 Bahan Kayu.',
            ],
            [
                'category_id' => 5,
                'name' => 'Meja Besi',
                'code' => 'GEN-007',
                'quantity' => 1,
                'description' => 'Inventaris sekre.',
            ],
            [
                'category_id' => 5,
                'name' => 'Bendera MPU',
                'code' => 'GEN-006',
                'quantity' => 2,
                'description' => 'Kondisi kotor.',
            ],
            [
                'category_id' => 5,
                'name' => 'Kipas Angin',
                'code' => 'GEN-005',
                'quantity' => 1,
                'description' => 'Inventaris sekre.',
            ],
            [
                'category_id' => 5,
                'name' => 'Panji',
                'code' => 'GEN-004',
                'quantity' => 1,
                'description' => 'Bendera pataka / panji organisasi.',
            ],
            [
                'category_id' => 5,
                'name' => 'Bendera',
                'code' => 'GEN-003',
                'quantity' => 1,
                'description' => 'Bendera organisasi / umum.',
            ],
            [
                'category_id' => 5,
                'name' => 'Kain Kasa',
                'code' => 'GEN-002',
                'quantity' => 2,
                'description' => 'Peralatan medis / P3K.',
            ],
            [
                'category_id' => 5,
                'name' => 'Tabung Oksigen',
                'code' => 'GEN-001',
                'quantity' => 2,
                'description' => 'Peralatan medis / safety pertama.',
            ],

            // ==========================================
            // KATEGORI 4: MOUNTAINEERING & RC
            // ==========================================
            [
                'category_id' => 4,
                'name' => 'Tali Karmantel Lembut',
                'code' => 'MNT-005',
                'quantity' => 1,
                'description' => 'Tali utama mountaineering/climbing.',
            ],
            [
                'category_id' => 4,
                'name' => 'Figure Eight',
                'code' => 'MNT-004',
                'quantity' => 2,
                'description' => 'Alat descender (Kondisi aman).',
            ],
            [
                'category_id' => 4,
                'name' => 'Carabiner Oval',
                'code' => 'MNT-003',
                'quantity' => 5,
                'description' => 'Kondisi aman.',
            ],
            [
                'category_id' => 4,
                'name' => 'Helm Safety',
                'code' => 'MNT-002',
                'quantity' => 3,
                'description' => 'Pelindung kepala (Kondisi aman).',
            ],
            [
                'category_id' => 4,
                'name' => 'Webbing',
                'code' => 'MNT-001',
                'quantity' => 10,
                'description' => 'Tali pipih. Catatan: Satu berukuran besar.',
            ],

            // ==========================================
            // KATEGORI 3: NAVIGASI & DIKLAT
            // ==========================================
            [
                'category_id' => 3,
                'name' => 'Kompas Silva',
                'code' => 'NAV-003',
                'quantity' => 4,
                'description' => 'Kompas orienteering / analisa peta.',
            ],
            [
                'category_id' => 3,
                'name' => 'Protraktor',
                'code' => 'NAV-002',
                'quantity' => 8,
                'description' => 'Alat bantu hitung koordinat peta.',
            ],
            [
                'category_id' => 3,
                'name' => 'Kompas Bidik',
                'code' => 'NAV-001',
                'quantity' => 3,
                'description' => 'Alat navigasi darat. Catatan: Rusak tutupnya 1.',
            ],

            // ==========================================
            // KATEGORI 2: PERALATAN MEMASAK
            // ==========================================
            [
                'category_id' => 2,
                'name' => 'Mangkok Keramik',
                'code' => 'KCH-016',
                'quantity' => 4,
                'description' => 'Peralatan makan/minum.',
            ],
            [
                'category_id' => 2,
                'name' => 'Piring Keramik',
                'code' => 'KCH-015',
                'quantity' => 5,
                'description' => 'Peralatan makan/minum.',
            ],
            [
                'category_id' => 2,
                'name' => 'Gelas Kaca',
                'code' => 'KCH-014',
                'quantity' => 6,
                'description' => 'Peralatan makan/minum.',
            ],
            [
                'category_id' => 2,
                'name' => 'Kompor Parafin',
                'code' => 'KCH-013',
                'quantity' => 6,
                'description' => 'Kondisi aman.',
            ],
            [
                'category_id' => 2,
                'name' => 'Jerigen Standar',
                'code' => 'KCH-012',
                'quantity' => 3,
                'description' => 'Wadah air kaku. Catatan: Tutup hilang 2.',
            ],
            [
                'category_id' => 2,
                'name' => 'Panci Kecil',
                'code' => 'KCH-011',
                'quantity' => 2,
                'description' => 'Dua set panci logistik.',
            ],
            [
                'category_id' => 2,
                'name' => 'Panci Besar',
                'code' => 'KCH-010',
                'quantity' => 2,
                'description' => 'Dua set panci logistik.',
            ],
            [
                'category_id' => 2,
                'name' => 'Wajan Kecil',
                'code' => 'KCH-009',
                'quantity' => 1,
                'description' => 'Satu set wajan logistik.',
            ],
            [
                'category_id' => 2,
                'name' => 'Wajan Besar',
                'code' => 'KCH-008',
                'quantity' => 1,
                'description' => 'Satu set wajan logistik.',
            ],
            [
                'category_id' => 2,
                'name' => 'Kompor Gunung Standar',
                'code' => 'KCH-007',
                'quantity' => 2,
                'description' => 'Kondisi rusak.',
            ],
            [
                'category_id' => 2,
                'name' => 'Kompor Portable',
                'code' => 'KCH-006',
                'quantity' => 9,
                'description' => 'Kondisi rusak semua.',
            ],
            [
                'category_id' => 2,
                'name' => 'Rice Cooker',
                'code' => 'KCH-005',
                'quantity' => 1,
                'description' => 'Peralatan masak elektronik sekre.',
            ],
            [
                'category_id' => 2,
                'name' => 'Galon',
                'code' => 'KCH-004',
                'quantity' => 2,
                'description' => 'Wadah air bersih.',
            ],
            [
                'category_id' => 2,
                'name' => 'Jerigen Lipat',
                'code' => 'KCH-003',
                'quantity' => 3,
                'description' => 'Wadah air lipat. Catatan: 1 tutup hilang.',
            ],
            [
                'category_id' => 2,
                'name' => 'Nesting',
                'code' => 'KCH-002',
                'quantity' => 4,
                'description' => 'Peralatan masak lapangan. Catatan: Tutup hilang.',
            ],
            [
                'category_id' => 2,
                'name' => 'Tabung Gas Portable',
                'code' => 'KCH-001',
                'quantity' => 9,
                'description' => 'Kondisi aman.',
            ],

            // ==========================================
            // KATEGORI 1: PERALATAN CAMPING & LOGISTIK
            // ==========================================
            [
                'category_id' => 1,
                'name' => 'Rain Cover',
                'code' => 'CMP-007',
                'quantity' => 6,
                'description' => 'Pelindung carrier dari hujan.',
            ],
            [
                'category_id' => 1,
                'name' => 'Sleeping Bag (SB)',
                'code' => 'CMP-006',
                'quantity' => 3,
                'description' => 'Kondisi rusak pada bagian resleting.',
            ],
            [
                'category_id' => 1,
                'name' => 'Terpal',
                'code' => 'CMP-005',
                'quantity' => 2,
                'description' => 'Kondisi aman.',
            ],
            [
                'category_id' => 1,
                'name' => 'Tenda Kapasitas 5',
                'code' => 'CMP-004',
                'quantity' => 1,
                'description' => 'Kondisi bolong dan tidak ada pasak.',
            ],
            [
                'category_id' => 1,
                'name' => 'Carrier',
                'code' => 'CMP-003',
                'quantity' => 2,
                'description' => 'Kondisi rusak dan sobek.',
            ],
            [
                'category_id' => 1,
                'name' => 'Matras',
                'code' => 'CMP-002',
                'quantity' => 4,
                'description' => 'Matras gulung standar kegiatan alam.',
            ],
            [
                'category_id' => 1,
                'name' => 'Flysheet',
                'code' => 'CMP-001',
                'quantity' => 2,
                'description' => 'Kondisi aman.',
            ],
        ]);
    }
}
