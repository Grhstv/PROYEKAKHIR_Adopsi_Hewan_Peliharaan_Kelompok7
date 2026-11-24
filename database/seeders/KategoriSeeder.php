<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Kucing', 'Anjing', 'Kelinci', 'Burung', 'Hamster'] as $nama) {
            Kategori::firstOrCreate(['slug' => Str::slug($nama)], ['nama' => $nama]);
        }
    }
}
