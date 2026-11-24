<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Password akun contoh. Ganti lewat env (SEED_PASSWORD) jika dipakai di production.
        $password = Hash::make(env('SEED_PASSWORD', 'password123'));

        $admin = User::firstOrCreate(
            ['email' => 'admin@adopsihewan.com'],
            ['name' => 'Admin Shelter', 'password' => $password]
        );
        $admin->syncRoles('admin');

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@adopsihewan.com'],
            ['name' => 'Petugas Shelter', 'password' => $password]
        );
        $petugas->syncRoles('petugas');

        foreach ([
            ['adopter@adopsihewan.com', 'Adopter Satu'],
            ['adopter2@adopsihewan.com', 'Adopter Dua'],
        ] as [$email, $nama]) {
            $u = User::firstOrCreate(['email' => $email], ['name' => $nama, 'password' => $password]);
            $u->syncRoles('adopter');
        }
    }
}
