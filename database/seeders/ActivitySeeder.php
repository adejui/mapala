<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activityTypes = ['meeting', 'basic training', 'exploration', 'anniversary', 'others'];
        $colors = ['danger', 'success', 'primary', 'warning', 'orange'];

        $titles = [
            'Rapat Koordinasi Pendakian Gunung Lawu',
            'Diklat Dasar Angkatan XX',
            'Ekspedisi Gunung Merapi 2026',
            'Perayaan Ulang Tahun Mapala Tarantula ke-15',
            'Rapat Pembahasan Proposal Ekspedisi',
            'Diklat Fisik dan Survival Dasar',
            'Eksplorasi Goa Pindul Gunungkidul',
            'Peringatan Hari Pahlawan di Puncak Merbabu',
            'Pelatihan Navigasi Darat untuk Anggota Baru',
            'Rapat Akhir Tahun dan Evaluasi Kegiatan',
            'Pendakian Bersama Alumni Mapala Kampus',
            'Bakti Sosial ke Desa Lereng Sumbing'
        ];

        $locations = [
            'Gunung Lawu, Jawa Tengah',
            'Kampus UBSI Yogyakarta',
            'Gunung Merapi, Sleman',
            'Basecamp Mapala Tarantula',
            'Sekretariat Mapala Tarantula',
            'Lapangan Kampus UBSI Yogyakarta',
            'Goa Pindul, Gunungkidul',
            'Gunung Merbabu, Magelang',
            'Hutan Wanagama, Gunungkidul',
            'Aula Kampus UBSI Yogyakarta',
            'Gunung Sumbing, Wonosobo',
            'Desa Pagergunung, Temanggung'
        ];

        $descriptions = [
            'Rapat koordinasi untuk membahas persiapan pendakian Gunung Lawu, mulai dari pembagian tugas, pengecekan perlengkapan, penyusunan logistik, hingga penentuan jadwal keberangkatan dan kepulangan.',

            'Pendidikan dan Latihan Dasar (DIKLATSAR) bagi calon anggota baru yang bertujuan memberikan pembekalan mengenai organisasi, kepemimpinan, etika pecinta alam, serta teknik dasar kegiatan alam bebas.',

            'Ekspedisi pendakian Gunung Merapi sebagai kegiatan pengembangan kemampuan teknis anggota dalam navigasi, manajemen perjalanan, keselamatan, serta observasi kondisi jalur pendakian.',

            'Perayaan hari jadi Mapala Tarantula yang diisi dengan acara syukuran, refleksi perjalanan organisasi, pemberian penghargaan kepada anggota berprestasi, serta mempererat kebersamaan seluruh anggota.',

            'Rapat pembahasan proposal kegiatan ekspedisi yang meliputi penyusunan anggaran, pembagian tanggung jawab panitia, serta evaluasi kesiapan administrasi sebelum kegiatan dilaksanakan.',

            'Pelatihan fisik dan survival dasar yang bertujuan meningkatkan daya tahan tubuh, kemampuan bertahan hidup di alam terbuka, serta keterampilan menghadapi situasi darurat.',

            'Kegiatan eksplorasi Goa Pindul sebagai sarana praktik teknik susur goa, penggunaan perlengkapan keselamatan, serta edukasi mengenai pentingnya menjaga kelestarian lingkungan.',

            'Pendakian dalam rangka memperingati Hari Pahlawan dengan tujuan menumbuhkan rasa nasionalisme, kebersamaan, serta mengenang jasa para pahlawan melalui kegiatan positif di alam.',

            'Pelatihan navigasi darat menggunakan peta, kompas, GPS, dan orientasi medan guna meningkatkan kemampuan anggota dalam menentukan arah selama kegiatan lapangan.',

            'Rapat akhir tahun yang membahas evaluasi seluruh program kerja, pencapaian organisasi selama satu tahun, serta penyusunan rencana kegiatan pada periode berikutnya.',

            'Pendakian bersama alumni sebagai ajang mempererat silaturahmi antarangkatan, berbagi pengalaman, memperluas jaringan, serta membangun kekompakan keluarga besar Mapala Tarantula.',

            'Kegiatan bakti sosial di Desa Pagergunung berupa aksi bersih lingkungan, penanaman pohon, edukasi pelestarian alam, serta penyaluran bantuan kepada masyarakat sekitar.'
        ];

        $data = [];

        for ($i = 0; $i < count($titles); $i++) {

            // Hanya satu activity bertipe "others"
            if ($i == 11) {
                $type = 'others';
            } else {
                $type = $activityTypes[rand(0, 3)];
            }

            // Acak tanggal Mei - Desember 2026
            $start = Carbon::create(2026, rand(5, 12), rand(1, 25));
            $end = (clone $start)->addDays(rand(1, 5));

            $data[] = [
                'title' => $titles[$i],
                'activity_type' => $type,
                'color' => $colors[array_rand($colors)],
                'start_date' => $start,
                'end_date' => $end,
                'location' => $locations[$i],
                'description' => $descriptions[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Activity::insert($data);
    }
}
