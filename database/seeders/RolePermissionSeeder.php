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
            'lihat dashboard admin',
            'kelola hewan',
            'kelola kategori',
            'kelola pengajuan adopsi',
            'kelola pesan pelanggan',
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
            'lihat dashboard admin', 'kelola hewan', 'kelola kategori',
            'kelola pengajuan adopsi', 'kelola pesan pelanggan', 'kelola pengguna',
            'kelola syarat dan ketentuan',
        ]);

        // Petugas: staf shelter yang mengelola hewan dan memproses pengajuan, tanpa kategori/pengguna.
        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $petugas->syncPermissions(['lihat dashboard admin', 'kelola hewan', 'kelola pengajuan adopsi']);

        $adopter = Role::firstOrCreate(['name' => 'adopter', 'guard_name' => 'web']);
        $adopter->syncPermissions(['mengajukan adopsi', 'melihat riwayat adopsi sendiri']);
    }
}
