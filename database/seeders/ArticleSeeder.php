<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [

            // ================= MEETING (2) =================
            [
                'activity_id' => 1,
                'title' => 'Rapat Koordinasi Program Kerja 2025',
                'slug' => Str::slug('Rapat Koordinasi Program Kerja 2025'),
                'content' => '
            <h2>Pembukaan Rapat</h2>
            <p>Rapat dimulai pukul 19.00 WIB dengan pembahasan program kerja tahunan Mapala Tarantula.</p>
            <h3>Poin Pembahasan</h3>
            <ul>
                <li>Evaluasi kegiatan sebelumnya</li>
                <li>Perencanaan kegiatan mendatang</li>
                <li>Pembagian divisi tugas</li>
            </ul>
            <p>Rapat berjalan lancar dan menghasilkan kesepakatan bersama.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => now(),
            ],
            [
                'activity_id' => 1,
                'title' => 'Rapat Evaluasi Tengah Tahun',
                'slug' => Str::slug('Rapat Evaluasi Tengah Tahun'),
                'content' => '
            <h2>Evaluasi Program</h2>
            <p>Kegiatan evaluasi dilakukan untuk melihat progres program kerja yang telah berjalan selama 6 bulan.</p>
            <h3>Hasil Evaluasi</h3>
            <ul>
                <li>80% program terlaksana</li>
                <li>Kendala pada logistik kegiatan luar</li>
            </ul>
            <p>Ditetapkan perbaikan untuk semester berikutnya.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => now(),
            ],

            // ================= BASIC TRAINING (2) =================
            [
                'activity_id' => 2,
                'title' => 'Diksar Mapala Tarantula 2025',
                'slug' => Str::slug('Diksar Mapala Tarantula 2025'),
                'content' => '
            <h2>Pelatihan Dasar</h2>
            <p>Kegiatan pendidikan dasar diikuti oleh 15 calon anggota baru.</p>
            <h3>Materi Pelatihan</h3>
            <ul>
                <li>Navigasi darat</li>
                <li>Manajemen perjalanan</li>
                <li>Survival dasar</li>
            </ul>
            <p>Seluruh peserta berhasil menyelesaikan pelatihan.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => now(),
            ],
            [
                'activity_id' => 2,
                'title' => 'Latihan Survival Dasar',
                'slug' => Str::slug('Latihan Survival Dasar'),
                'content' => '
            <h2>Simulasi Bertahan Hidup</h2>
            <p>Peserta dilatih untuk bertahan hidup di alam terbuka dengan sumber daya terbatas.</p>
            <h3>Latihan</h3>
            <ul>
                <li>Membuat api tanpa korek</li>
                <li>Mencari sumber air</li>
            </ul>
            <p>Kegiatan berlangsung selama 2 hari.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(11),
                'updated_at' => now(),
            ],

            // ================= EXPLORATION (5) =================
            [
                'activity_id' => 3,
                'title' => 'Perjalanan Ekspedisi Gunung Merapi 2025',
                'slug' => Str::slug('Perjalanan Ekspedisi Gunung Merapi 2025'),
                'content' => '
            <h2>Persiapan Ekspedisi</h2>
            <p>Tim melakukan persiapan matang sebelum pendakian.</p>
            <h3>Perlengkapan</h3>
            <ul>
                <li>Tenda</li>
                <li>Kompor</li>
                <li>Logistik</li>
            </ul>
            <p>Semua anggota berhasil mencapai puncak.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => now(),
            ],
            [
                'activity_id' => 3,
                'title' => 'Eksplorasi Hutan Pinus',
                'slug' => Str::slug('Eksplorasi Hutan Pinus'),
                'content' => '
            <h2>Penjelajahan</h2>
            <p>Kegiatan eksplorasi dilakukan untuk pemetaan jalur baru.</p>
            <h3>Temuan</h3>
            <ul>
                <li>Sumber air baru</li>
                <li>Spot camping</li>
            </ul>
            <p>Lokasi sangat potensial untuk kegiatan selanjutnya.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(9),
                'updated_at' => now(),
            ],
            [
                'activity_id' => 3,
                'title' => 'Pendakian Gunung Slamet',
                'slug' => Str::slug('Pendakian Gunung Slamet'),
                'content' => '
            <h2>Pendakian</h2>
            <p>Tim melakukan pendakian melalui jalur Bambangan.</p>
            <h3>Kondisi</h3>
            <ul>
                <li>Cuaca dingin</li>
                <li>Angin kencang</li>
            </ul>
            <p>Perjalanan berjalan dengan aman.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => now(),
            ],
            [
                'activity_id' => 3,
                'title' => 'Eksplorasi Goa Alam',
                'slug' => Str::slug('Eksplorasi Goa Alam'),
                'content' => '
            <h2>Penelusuran Goa</h2>
            <p>Tim menyusuri goa dengan peralatan lengkap.</p>
            <h3>Peralatan</h3>
            <ul>
                <li>Headlamp</li>
                <li>Tali</li>
            </ul>
            <p>Goa memiliki struktur unik dan menarik.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => now(),
            ],
            [
                'activity_id' => 3,
                'title' => 'Survey Jalur Pendakian Baru',
                'slug' => Str::slug('Survey Jalur Pendakian Baru'),
                'content' => '
            <h2>Survey</h2>
            <p>Tim melakukan survey jalur alternatif.</p>
            <h3>Hasil</h3>
            <ul>
                <li>Jalur lebih landai</li>
                <li>Aman untuk pemula</li>
            </ul>
            <p>Direkomendasikan untuk kegiatan berikutnya.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => now(),
            ],

            // ================= ANNIVERSARY (2) =================
            [
                'activity_id' => 4,
                'title' => 'Perayaan Anniversary ke-10',
                'slug' => Str::slug('Perayaan Anniversary ke-10'),
                'content' => '
            <h2>Perayaan</h2>
            <p>Acara dihadiri oleh anggota aktif dan alumni.</p>
            <h3>Rangkaian Acara</h3>
            <ul>
                <li>Potong tumpeng</li>
                <li>Sharing alumni</li>
            </ul>
            <p>Acara berlangsung meriah.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => now(),
            ],
            [
                'activity_id' => 4,
                'title' => 'Syukuran Ulang Tahun Organisasi',
                'slug' => Str::slug('Syukuran Ulang Tahun Organisasi'),
                'content' => '
            <h2>Syukuran</h2>
            <p>Diadakan doa bersama sebagai bentuk rasa syukur.</p>
            <h3>Kegiatan</h3>
            <ul>
                <li>Doa bersama</li>
                <li>Makan bersama</li>
            </ul>
            <p>Menambah kekompakan anggota.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => now(),
            ],

            // ================= OTHERS (2) =================
            [
                'activity_id' => 5,
                'title' => 'Bakti Sosial Desa Binaan',
                'slug' => Str::slug('Bakti Sosial Desa Binaan'),
                'content' => '
            <h2>Kegiatan Sosial</h2>
            <p>Anggota melakukan kegiatan sosial di desa terpencil.</p>
            <h3>Kegiatan</h3>
            <ul>
                <li>Pembagian sembako</li>
                <li>Penyuluhan lingkungan</li>
            </ul>
            <p>Masyarakat sangat antusias.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => now(),
            ],
            [
                'activity_id' => 5,
                'title' => 'Pelatihan Fotografi Alam',
                'slug' => Str::slug('Pelatihan Fotografi Alam'),
                'content' => '
            <h2>Workshop</h2>
            <p>Pelatihan fotografi untuk anggota.</p>
            <h3>Materi</h3>
            <ul>
                <li>Teknik dasar fotografi</li>
                <li>Komposisi gambar</li>
            </ul>
            <p>Peserta mendapatkan ilmu baru.</p>
        ',
                'status' => 'published',
                'file_path' => null,
                'created_at' => Carbon::now(),
                'updated_at' => now(),
            ],

        ];

        Article::insert($articles);
    }
}
