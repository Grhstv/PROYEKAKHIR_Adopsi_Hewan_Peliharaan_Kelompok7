<?php

namespace Database\Seeders;

use App\Models\Hewan;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class HewanTambahanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kucing', 'Suki', 'Siamese', 'betina', 9, 'Krem cokelat', 'Suki suka bermain dan mudah mengenali pengasuhnya. Ia mencari rumah yang nyaman dan rutin dirawat.', true, false, 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=900&q=85'],
            ['kucing', 'Kuro', 'British Shorthair', 'jantan', 16, 'Abu-abu', 'Kuro tenang dan senang berada di dekat keluarga. Ia sudah terbiasa menggunakan litter box.', true, true, 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?auto=format&fit=crop&w=900&q=85'],
            ['kucing', 'Mimi', 'Ragdoll', 'betina', 12, 'Putih abu-abu', 'Mimi lembut dan mudah akrab setelah mengenal lingkungan baru. Sisir bulunya secara berkala.', true, false, 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=900&q=85'],
            ['kucing', 'Taro', 'Munchkin', 'jantan', 6, 'Cokelat putih', 'Taro aktif menjelajahi rumah dan senang bermain dengan mainan ringan. Ia membutuhkan ruang yang aman.', false, false, 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=900&q=85'],
            ['kucing', 'Kiki', 'Sphynx', 'betina', 20, 'Merah muda', 'Kiki ramah dan suka ditemani. Kulitnya perlu dijaga kebersihannya sesuai arahan dokter hewan.', true, true, 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=900&q=85'],
            ['kucing', 'Sasha', 'Maine Coon', 'betina', 26, 'Cokelat tabby', 'Sasha kalem dan suka mengamati lingkungan. Calon adopter perlu rutin menyisir bulunya yang lebat.', true, false, 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?auto=format&fit=crop&w=900&q=85'],
            ['kucing', 'Oyen', 'Bengal', 'jantan', 11, 'Oranye belang', 'Oyen penuh rasa ingin tahu dan senang bermain. Sediakan aktivitas dan tempat bermain yang aman.', true, false, 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=900&q=85'],
            ['kucing', 'Loki', 'Anggora Mix', 'jantan', 14, 'Putih krem', 'Loki ramah dan terbiasa tinggal di dalam rumah. Informasi asal ras dapat dikonfirmasi saat bertemu.', false, false, 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=900&q=85'],
            ['anjing', 'Astra', 'Shiba Inu', 'betina', 17, 'Merah krem', 'Astra cerdas dan aktif berjalan-jalan. Ia membutuhkan latihan positif dan rutinitas harian.', true, true, 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=900&q=85'],
            ['anjing', 'Rex', 'German Shepherd', 'jantan', 28, 'Hitam cokelat', 'Rex tanggap dan setia kepada pengasuh yang dikenalnya. Ia cocok dengan keluarga yang siap beraktivitas.', true, false, 'https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=900&q=85'],
            ['anjing', 'Coco', 'Poodle', 'betina', 13, 'Krem', 'Coco mudah diajak berinteraksi dan senang belajar. Bulu keritingnya perlu perawatan teratur.', true, true, 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=900&q=85'],
            ['anjing', 'Bimo', 'Siberian Husky', 'jantan', 22, 'Putih abu-abu', 'Bimo ceria dan bertenaga. Ia memerlukan olahraga rutin serta lingkungan yang berpagar aman.', true, false, 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=900&q=85'],
            ['anjing', 'Toby', 'Dachshund', 'jantan', 10, 'Cokelat', 'Toby penasaran dan suka mengikuti pengasuhnya. Jaga aktivitasnya agar tetap sesuai kondisi tubuhnya.', false, false, 'https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=900&q=85'],
            ['anjing', 'Boni', 'Border Collie', 'betina', 19, 'Hitam putih', 'Boni cepat belajar dan menyukai permainan interaktif. Ia cocok untuk keluarga yang aktif.', true, true, 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=900&q=85'],
            ['anjing', 'Moka', 'French Bulldog', 'betina', 15, 'Cokelat muda', 'Moka penyayang dan senang beristirahat dekat keluarga. Perhatikan kebutuhan kesehatan dan kenyamanannya.', true, false, 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=900&q=85'],
            ['anjing', 'Maya', 'Labrador Retriever', 'betina', 24, 'Kuning', 'Maya ramah dan suka bermain lempar tangkap. Ia mencari keluarga yang dapat menemaninya berolahraga.', true, true, 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=900&q=85'],
            ['kelinci', 'Lola', 'Mini Rex', 'betina', 7, 'Abu-abu', 'Lola lembut dan nyaman berada di tempat yang tenang. Sediakan hay, air bersih, dan ruang bergerak.', true, false, 'https://images.pexels.com/photos/247373/pexels-photo-247373.jpeg'],
            ['kelinci', 'Snowy', 'Dutch', 'jantan', 9, 'Putih hitam', 'Snowy aktif menjelajahi area bermain. Ia perlu kandang luas dan interaksi harian yang lembut.', false, false, 'https://images.pexels.com/photos/4588065/pexels-photo-4588065.jpeg'],
            ['kelinci', 'Tofu', 'Lionhead', 'jantan', 5, 'Putih krem', 'Tofu suka mengunyah hay dan beristirahat di tempat teduh. Bulu di sekitar kepalanya perlu disisir.', true, false, 'https://images.pexels.com/photos/372166/pexels-photo-372166.jpeg'],
            ['kelinci', 'Pipi', 'Netherland Dwarf', 'betina', 8, 'Cokelat', 'Pipi bertubuh kecil dan pemalu saat awal bertemu. Beri waktu untuk beradaptasi dengan rumah baru.', false, false, 'https://images.pexels.com/photos/247373/pexels-photo-247373.jpeg'],
            ['burung', 'Rio', 'Cockatiel', 'jantan', 16, 'Abu-abu kuning', 'Rio aktif bersuara dan mulai terbiasa dengan manusia. Ia membutuhkan kandang bersih serta waktu berinteraksi.', false, false, 'https://images.unsplash.com/photo-1444464666168-49d633b86797?auto=format&fit=crop&w=900&q=85'],
            ['burung', 'Blue', 'Budgerigar', 'betina', 10, 'Biru putih', 'Blue lincah dan senang bertengger. Letakkan kandangnya di area aman dengan sirkulasi udara yang baik.', false, false, 'https://images.unsplash.com/photo-1444464666168-49d633b86797?auto=format&fit=crop&w=900&q=85'],
            ['burung', 'Sunny', 'Kenari', 'jantan', 18, 'Kuning', 'Sunny berkicau pada pagi hari dan menyukai suasana tenang. Jaga kebersihan kandang dan air minumnya.', false, false, 'https://images.unsplash.com/photo-1444464666168-49d633b86797?auto=format&fit=crop&w=900&q=85'],
            ['hamster', 'Peanut', 'Roborovski', 'jantan', 3, 'Cokelat pasir', 'Peanut sangat lincah dan aktif pada malam hari. Gunakan kandang aman dengan roda dan alas yang sesuai.', false, false, 'https://images.unsplash.com/photo-1425082661705-1834bfd09dca?auto=format&fit=crop&w=900&q=85'],
            ['hamster', 'Nori', 'Winter White', 'betina', 4, 'Abu-abu putih', 'Nori suka menggali alas kandang dan menyimpan makanan. Berikan tempat persembunyian yang nyaman.', false, false, 'https://images.unsplash.com/photo-1425082661705-1834bfd09dca?auto=format&fit=crop&w=900&q=85'],
            ['hamster', 'Koko', 'Campbell', 'jantan', 5, 'Cokelat krem', 'Koko aktif menjelajahi kandangnya. Ia perlu lingkungan yang tenang dan penanganan yang hati-hati.', false, false, 'https://images.unsplash.com/photo-1425082661705-1834bfd09dca?auto=format&fit=crop&w=900&q=85'],
            ['ikan', 'Biru', 'Cupang Halfmoon', 'jantan', 6, 'Biru merah', 'Ikan cupang ini dipelihara dalam wadah bersih dengan kualitas air yang terjaga. Pastikan kebutuhan airnya dipenuhi.', false, false, 'https://images.unsplash.com/photo-1524704654690-b56c05c78a00?auto=format&fit=crop&w=900&q=85'],
            ['ikan', 'Guppy', 'Guppy Fancy', 'betina', 4, 'Warna-warni', 'Guppy aktif berenang dan cocok untuk akuarium yang sudah disiapkan dengan baik.', false, false, 'https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?auto=format&fit=crop&w=900&q=85'],
            ['ikan', 'Koi', 'Koi Kohaku', 'jantan', 14, 'Putih merah', 'Koi memerlukan kolam dengan filtrasi yang sesuai dan kualitas air stabil. Pastikan kapasitas kolam mencukupi.', false, false, 'https://images.unsplash.com/photo-1535591273668-578e31182c4f?auto=format&fit=crop&w=900&q=85'],
            ['ikan', 'Goldie', 'Goldfish Oranda', 'betina', 8, 'Oranye putih', 'Goldie berenang aktif dan perlu akuarium berfilter dengan ruang yang cukup untuk tumbuh.', false, false, 'https://images.pexels.com/photos/128756/pexels-photo-128756.jpeg'],
        ];

        foreach ($data as [$slug, $nama, $ras, $jenisKelamin, $umur, $warna, $deskripsi, $vaksin, $steril, $fotoUrl]) {
            $kategori = Kategori::where('slug', $slug)->first();
            if (! $kategori) {
                continue;
            }

            Hewan::updateOrCreate(
                ['nama' => $nama, 'kategori_id' => $kategori->id],
                [
                    'ras' => $ras,
                    'jenis_kelamin' => $jenisKelamin,
                    'umur_bulan' => $umur,
                    'warna' => $warna,
                    'deskripsi' => $deskripsi,
                    'kesehatan' => $vaksin ? 'Sehat, vaksin lengkap' : 'Sehat, belum divaksin',
                    'sudah_vaksin' => $vaksin,
                    'sudah_steril' => $steril,
                    'status' => 'tersedia',
                    'foto_url' => $fotoUrl,
                ]
            );
        }
    }
}
