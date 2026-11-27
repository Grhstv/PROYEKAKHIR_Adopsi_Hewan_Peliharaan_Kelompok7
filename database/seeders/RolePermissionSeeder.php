<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $semua = [
            'akses area admin',
            'akses area petugas',
            'lihat laporan',
            'kelola pengajuan seller',
            'kelola chat',
            'lihat chat',
            'kirim chat',
            'belanja produk',
            'kelola toko',
            'mengajukan menjadi seller',
            'lihat dashboard admin',
            'kelola hewan',
            'kelola kategori',
            'kelola pengajuan adopsi',
            'kelola pengguna',
            'kelola syarat dan ketentuan',
            'mengajukan adopsi',
            'melihat riwayat adopsi sendiri',
        ];
        foreach ($semua as $nama) {
            Permission::firstOrCreate(['name' => $nama, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'akses area admin', 'lihat laporan', 'kelola pengajuan seller', 'kelola chat',
            'lihat dashboard admin', 'kelola hewan', 'kelola kategori',
            'kelola pengajuan adopsi', 'kelola pengguna', 'kelola syarat dan ketentuan',
        ]);

        // Petugas handles shelter operations but cannot enter the admin area or view reports.
        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $petugas->syncPermissions(['akses area petugas', 'kelola hewan', 'kelola pengajuan adopsi']);

        $adopter = Role::firstOrCreate(['name' => 'adopter', 'guard_name' => 'web']);
        $adopter->syncPermissions([
            'mengajukan adopsi',
            'melihat riwayat adopsi sendiri',
            'lihat chat',
            'kirim chat',
            'belanja produk',
            'mengajukan menjadi seller',
        ]);

        $seller = Role::firstOrCreate(['name' => 'seller', 'guard_name' => 'web']);
        $seller->syncPermissions(['kelola toko', 'belanja produk', 'lihat chat', 'kirim chat']);
    }
}
