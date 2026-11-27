<?php

namespace Tests\Feature;

use App\Models\Adopsi;
use App\Models\Hewan;
use App\Models\HewanMutation;
use App\Models\Kategori;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function user(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function adoption(User $user, string $animalName): Adopsi
    {
        $kategori = Kategori::firstOrCreate(['slug' => 'kucing'], ['nama' => 'Kucing']);
        $hewan = Hewan::create([
            'kategori_id' => $kategori->id,
            'nama' => $animalName,
            'jenis_kelamin' => 'betina',
            'umur_bulan' => 8,
            'deskripsi' => 'Hewan untuk pengujian laporan.',
            'status' => Hewan::TERSEDIA,
        ]);

        return Adopsi::create([
            'user_id' => $user->id,
            'hewan_id' => $hewan->id,
            'alasan' => 'Ingin merawat hewan.',
            'tempat_tinggal' => 'rumah_sendiri',
            'pengalaman' => 'pernah',
            'no_telepon' => '081234567890',
            'status' => Adopsi::MENUNGGU,
        ]);
    }

    public function test_guest_is_redirected_from_admin_report(): void
    {
        $this->get(route('admin.laporan.index'))->assertRedirect(route('login'));
    }

    public function test_admin_and_petugas_can_open_admin_report(): void
    {
        $adopter = $this->user('adopter');
        $this->adoption($adopter, 'Mochi');

        $this->actingAs($this->user('admin'))
            ->get(route('admin.laporan.index'))
            ->assertOk()
            ->assertSee('Laporan Pengajuan Adopsi')
            ->assertSee('Cetak / Simpan PDF')
            ->assertSee('Mochi');

        $this->actingAs($this->user('petugas'))
            ->get(route('admin.laporan.index'))
            ->assertOk()
            ->assertSee('Mochi');
    }

    public function test_adopter_cannot_open_admin_report(): void
    {
        $this->actingAs($this->user('adopter'))
            ->get(route('admin.laporan.index'))
            ->assertForbidden();
    }

    public function test_admin_report_shows_animal_inventory_and_mutations(): void
    {
        $admin = $this->user('admin');
        $hewan = $this->adoption($this->user('adopter'), 'Milo');
        HewanMutation::create([
            'hewan_id' => $hewan->hewan_id,
            'nama_hewan' => 'Milo',
            'jenis' => HewanMutation::DITAMBAHKAN,
            'user_id' => $admin->id,
            'keterangan' => 'Hewan ditambahkan untuk pengujian.',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.laporan.index'))
            ->assertOk()
            ->assertSee('Ringkasan Semua Hewan')
            ->assertSee('Riwayat Bertambah dan Berkurang Hewan')
            ->assertSee('Bertambah')
            ->assertSee('Milo');
    }

    public function test_adopter_history_shows_only_own_records_without_a_report_link(): void
    {
        $owner = $this->user('adopter');
        $other = $this->user('adopter');
        $this->adoption($owner, 'Mochi Sendiri');
        $this->adoption($other, 'Poppy Orang Lain');

        $this->actingAs($owner)
            ->get(route('adopsi.index'))
            ->assertOk()
            ->assertSee('Riwayat Adopsi Saya')
            ->assertSee('Riwayat')
            ->assertSee('Mochi Sendiri')
            ->assertDontSee('Poppy Orang Lain')
            ->assertDontSee('Laporan saya');
    }

    public function test_customer_report_route_is_not_available(): void
    {
        $this->actingAs($this->user('adopter'))
            ->get('/laporan-saya')
            ->assertStatus(404);
    }
}
