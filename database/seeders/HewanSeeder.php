<?php

namespace Database\Seeders;

use App\Models\Hewan;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class HewanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kucing', 'Mochi', 'Kucing Domestik', 'betina', 8, 'Oranye putih', 'Mochi kucing manja yang suka tidur di pangkuan. Sudah terbiasa dengan anak-anak dan hewan lain, cocok untuk keluarga.', true, true, 'tersedia'],
            ['kucing', 'Leo', 'Persia', 'jantan', 24, 'Abu-abu', 'Leo tenang dan pemalu, tetapi sangat setia setelah akrab. Perlu disisir bulunya secara rutin.', true, true, 'tersedia'],
            ['kucing', 'Nala', 'Anggora', 'betina', 5, 'Putih', 'Nala masih kitten yang aktif dan suka bermain bola. Sudah bisa memakai litter box dengan baik.', true, false, 'tersedia'],
            ['kucing', 'Simba', 'Kucing Domestik', 'jantan', 36, 'Cokelat belang', 'Simba kucing rescue yang kini sehat dan sangat ramah. Sudah steril sehingga lebih tenang di rumah.', true, true, 'teradopsi'],
            ['anjing', 'Bruno', 'Golden Retriever', 'jantan', 18, 'Emas', 'Bruno ramah dan penuh energi, senang diajak berjalan pagi. Cocok untuk keluarga dengan halaman.', true, false, 'tersedia'],
            ['anjing', 'Luna', 'Pomeranian', 'betina', 12, 'Krem', 'Luna kecil dan lincah, mudah dilatih duduk dan memberi salam. Cocok untuk tinggal di apartemen.', true, true, 'tersedia'],
            ['anjing', 'Rocky', 'Kampung', 'jantan', 30, 'Hitam putih', 'Rocky anjing lokal yang cerdas dan penjaga rumah yang baik. Dirawat sejak kecil di shelter kami.', true, true, 'tersedia'],
            ['kelinci', 'Cloud', 'Holland Lop', 'betina', 6, 'Putih', 'Cloud kelinci lembut yang suka dielus. Makanannya hay, sayuran segar, dan sedikit pelet.', true, false, 'tersedia'],
            ['kelinci', 'Choco', 'Anggora', 'jantan', 10, 'Cokelat', 'Choco kelinci berbulu lebat yang tenang. Perlu kandang cukup luas dan sisir bulu mingguan.', false, false, 'tersedia'],
            ['burung', 'Kiko', 'Lovebird', 'jantan', 14, 'Hijau kuning', 'Kiko lovebird jinak yang bisa hinggap di jari. Berkicau ceria setiap pagi.', false, false, 'tersedia'],
            ['hamster', 'Pico', 'Syrian', 'jantan', 4, 'Cokelat muda', 'Pico hamster aktif di malam hari, suka berlari di roda. Mudah dirawat untuk pemula.', false, false, 'tersedia'],
            ['anjing', 'Max', 'Beagle', 'jantan', 20, 'Tricolor', 'Max beagle yang penasaran dan suka mencium segala hal. Sudah diadopsi oleh keluarga baru.', true, true, 'teradopsi'],
        ];

        foreach ($data as [$slug, $nama, $ras, $jk, $umur, $warna, $deskripsi, $vaksin, $steril, $status]) {
            $kategori = Kategori::where('slug', $slug)->first();
            if (! $kategori) {
                continue;
            }
            Hewan::updateOrCreate(
                ['nama' => $nama, 'kategori_id' => $kategori->id],
                [
                    'ras' => $ras,
                    'jenis_kelamin' => $jk,
                    'umur_bulan' => $umur,
                    'warna' => $warna,
                    'deskripsi' => $deskripsi,
                    'kesehatan' => $vaksin ? 'Sehat, vaksin lengkap' : 'Sehat, belum divaksin',
                    'sudah_vaksin' => $vaksin,
                    'sudah_steril' => $steril,
                    'status' => $status,
                ]
            );
        }
    }
}
