<?php

namespace Tests\Feature;

use App\Models\Adopsi;
use App\Models\Hewan;
use App\Models\Kategori;
use App\Models\TermsAndCondition;
use App\Models\User;
use Database\Seeders\HewanSeeder;
use Database\Seeders\KategoriSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Jalankan: php artisan test --filter=AdopsiTest
 * PERINGATAN: RefreshDatabase menghapus isi database. Jangan jalankan saat .env mengarah ke Supabase/production.
 */
class AdopsiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function user(string $role): User
    {
        $u = User::factory()->create();
        $u->assignRole($role);

        return $u;
    }

    private function hewan(string $status = 'tersedia'): Hewan
    {
        $k = Kategori::firstOrCreate(['slug' => 'kucing'], ['nama' => 'Kucing']);

        return Hewan::create([
            'kategori_id' => $k->id, 'nama' => 'Mochi', 'jenis_kelamin' => 'betina',
            'umur_bulan' => 8, 'deskripsi' => 'Kucing manja yang suka tidur di pangkuan.',
            'status' => $status,
        ]);
    }

    private function dataAdopsi(): array
    {
        return [
            'alasan' => 'Saya ingin merawatnya dengan penuh kasih sayang.',
            'tempat_tinggal' => 'rumah_sendiri', 'pengalaman' => 'pernah',
            'no_telepon' => '081234567890', 'setuju' => '1',
            'alamat_lengkap' => 'Jl. Mawar No. 10, Jakarta Selatan',
            'persetujuan_keluarga' => '1',
            'jadwal_perawatan' => 'Pagi dan sore setiap hari',
            'anggaran_bulanan' => '500000',
            'rencana_perawatan' => 'Memberi vaksin, pemeriksaan rutin, makanan sehat dan tempat tinggal aman.',
            'setuju_terms' => '1',
        ];
    }

    public function test_tamu_dapat_melihat_beranda_pethaven()
    {
        $this->hewan();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Temukan teman baru')
            ->assertSee('Mochi');
    }

    public function test_tamu_dapat_melihat_detail_hewan_dan_informasi_perawatannya()
    {
        $hewan = $this->hewan();

        $this->get(route('hewan.show', $hewan))
            ->assertOk()
            ->assertSee('Tentang Mochi')
            ->assertSee('Belum vaksin');
    }

    public function test_admin_dapat_melihat_template_deskripsi_iklan()
    {
        $this->actingAs($this->user('admin'))
            ->get(route('admin.hewan.create'))
            ->assertOk()
            ->assertSee('Gunakan format iklan')
            ->assertSee('Keterangan jika tanpa sertifikat')
            ->assertSee('Metode Serah Terima');
    }

    public function test_data_contoh_menyediakan_lebih_banyak_hewan_dengan_foto()
    {
        $this->seed([KategoriSeeder::class, HewanSeeder::class]);

        $this->assertDatabaseHas('hewans', ['nama' => 'Poppy']);
        $this->assertDatabaseHas('hewans', [
            'nama' => 'Poppy',
            'foto_url' => 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?auto=format&fit=crop&w=900&q=85',
        ]);
    }

    public function test_01_tamu_bisa_melihat_daftar_hewan()
    {
        $this->hewan();
        $this->get('/hewan')->assertOk()->assertSee('Mochi');
    }

    public function test_02_tamu_ke_halaman_admin_diarahkan_ke_login()
    {
        $this->get('/admin/hewan')->assertRedirect('/login');
    }

    public function test_03_adopter_tidak_boleh_membuka_halaman_admin()
    {
        $this->actingAs($this->user('adopter'))->get('/admin/hewan')->assertForbidden();
    }

    public function test_04_adopter_dapat_mengajukan_adopsi()
    {
        $h = $this->hewan();
        $u = $this->user('adopter');

        $this->actingAs($u)->post("/hewan/{$h->id}/adopsi", $this->dataAdopsi())
            ->assertRedirect(route('adopsi.index'));

        $this->assertDatabaseHas('adopsis', ['user_id' => $u->id, 'hewan_id' => $h->id, 'status' => 'menunggu']);
        $this->assertDatabaseHas('adopsis', [
            'user_id' => $u->id,
            'terms_snapshot' => TermsAndCondition::DEFAULT_CONTENT,
        ]);
        $this->assertNotNull(Adopsi::where('user_id', $u->id)->firstOrFail()->terms_accepted_at);
    }

    public function test_adopter_must_accept_the_current_terms_before_submitting(): void
    {
        $hewan = $this->hewan();
        $this->actingAs($this->user('adopter'))
            ->get(route('adopsi.create', $hewan))
            ->assertOk()
            ->assertSee('Syarat dan Ketentuan Adopsi');

        $data = $this->dataAdopsi();
        unset($data['setuju_terms']);

        $this->actingAs($this->user('adopter'))
            ->from(route('adopsi.create', $hewan))
            ->post(route('adopsi.store', $hewan), $data)
            ->assertRedirect(route('adopsi.create', $hewan))
            ->assertSessionHasErrors('setuju_terms');

        $this->assertDatabaseCount('adopsis', 0);
    }

    public function test_05_pengajuan_ganda_untuk_hewan_sama_ditolak()
    {
        $h = $this->hewan();
        $u = $this->user('adopter');

        $this->actingAs($u)->post("/hewan/{$h->id}/adopsi", $this->dataAdopsi());
        $this->post("/hewan/{$h->id}/adopsi", $this->dataAdopsi());

        $this->assertSame(1, Adopsi::where('user_id', $u->id)->count());
    }

    public function test_06_admin_tidak_boleh_mengajukan_adopsi()
    {
        $h = $this->hewan();
        $this->actingAs($this->user('admin'))->post("/hewan/{$h->id}/adopsi", $this->dataAdopsi())->assertForbidden();
    }

    public function test_07_setujui_menandai_teradopsi_dan_menolak_pengajuan_lain()
    {
        $h = $this->hewan();
        $a1 = $this->user('adopter');
        $a2 = $this->user('adopter');
        $x = Adopsi::create($this->dataAdopsi() + ['user_id' => $a1->id, 'hewan_id' => $h->id, 'status' => 'menunggu']);
        $y = Adopsi::create($this->dataAdopsi() + ['user_id' => $a2->id, 'hewan_id' => $h->id, 'status' => 'menunggu']);

        $this->actingAs($this->user('admin'))->post("/admin/adopsi/{$x->id}/setujui")->assertSessionHasNoErrors();

        $this->assertSame('teradopsi', $h->fresh()->status);
        $this->assertSame('disetujui', $x->fresh()->status);
        $this->assertSame('ditolak', $y->fresh()->status);
    }

    public function test_08_adopter_tidak_boleh_membatalkan_pengajuan_milik_orang_lain()
    {
        $h = $this->hewan();
        $pemilik = $this->user('adopter');
        $a = Adopsi::create($this->dataAdopsi() + ['user_id' => $pemilik->id, 'hewan_id' => $h->id, 'status' => 'menunggu']);

        $this->actingAs($this->user('adopter'))->delete("/adopsi-saya/{$a->id}")->assertForbidden();
        $this->assertSame('menunggu', $a->fresh()->status);

        $this->actingAs($pemilik)->delete("/adopsi-saya/{$a->id}");
        $this->assertSame('dibatalkan', $a->fresh()->status);
    }

    public function test_12_petugas_area_is_separate_and_excludes_admin_features()
    {
        $petugas = $this->user('petugas');
        $this->actingAs($petugas)->get('/petugas')->assertOk()->assertSee('Dashboard Petugas');
        $this->get('/petugas/hewan')->assertOk();
        $this->get('/petugas/adopsi')->assertOk();
        $this->get('/admin/hewan')->assertForbidden();
        $this->get('/admin/adopsi')->assertForbidden();
        $this->get('/admin/kategori')->assertForbidden();
        $this->get('/admin/pengguna')->assertForbidden();
        $this->get('/admin/laporan')->assertForbidden();
    }

    public function test_13_petugas_dapat_menyetujui_pengajuan()
    {
        $h = $this->hewan();
        $a = Adopsi::create($this->dataAdopsi() + ['user_id' => $this->user('adopter')->id, 'hewan_id' => $h->id, 'status' => 'menunggu']);

        $this->actingAs($this->user('petugas'))->post("/petugas/adopsi/{$a->id}/setujui");

        $this->assertSame('disetujui', $a->fresh()->status);
    }

    public function test_09_pendaftar_baru_otomatis_menjadi_adopter_walau_mengirim_role_admin()
    {
        $this->post('/register', [
            'name' => 'Budi', 'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => 'password123', 'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $u = User::where('email', 'budi@example.com')->firstOrFail();
        $this->assertTrue($u->hasRole('adopter'));
        $this->assertFalse($u->hasRole('admin'));
    }

    public function test_10_api_daftar_hewan_publik_dan_tulis_butuh_token()
    {
        $this->hewan();
        $this->getJson('/api/v1/hewan')->assertOk()->assertJsonStructure(['data', 'links', 'meta']);
        $this->postJson('/api/v1/hewan', [])->assertUnauthorized();
    }

    public function test_11_api_login_dan_tambah_hewan_dengan_token_admin()
    {
        $k = Kategori::create(['nama' => 'Kucing', 'slug' => 'kucing']);
        $admin = $this->user('admin');
        $admin->update(['password' => 'password123']);

        $token = $this->postJson('/api/v1/login', ['email' => $admin->email, 'password' => 'password123'])
            ->assertOk()->json('token');

        $this->withToken($token)->postJson('/api/v1/hewan', [
            'kategori_id' => $k->id, 'nama' => 'Leo', 'jenis_kelamin' => 'jantan',
            'umur_bulan' => 12, 'deskripsi' => 'Kucing tenang dan setia kepada pemiliknya.',
        ])->assertCreated();
    }
}
