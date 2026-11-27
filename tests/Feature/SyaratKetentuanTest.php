<?php

namespace Tests\Feature;

use App\Models\TermsAndCondition;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SyaratKetentuanTest extends TestCase
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

    public function test_anyone_can_read_default_terms_without_edit_controls(): void
    {
        $this->get(route('syarat-ketentuan.show'))
            ->assertOk()
            ->assertSee('Syarat dan Ketentuan Penggunaan PetHaven')
            ->assertDontSee('Edit Syarat')
            ->assertDontSee('<textarea', false);

        $this->assertDatabaseCount('terms_and_conditions', 0);
    }

    public function test_admin_can_update_terms_and_customers_see_escaped_content(): void
    {
        $content = "Ketentuan PetHaven yang sudah diperbarui untuk semua pengguna. <script>alert('x')</script>";

        $this->actingAs($this->user('admin'))
            ->get(route('admin.syarat-ketentuan.edit'))
            ->assertOk()
            ->assertSee('Simpan perubahan');

        $this->put(route('admin.syarat-ketentuan.update'), ['content' => $content])
            ->assertRedirectToRoute('admin.syarat-ketentuan.edit')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('terms_and_conditions', [
            'key' => TermsAndCondition::KEY,
            'content' => $content,
        ]);

        $this->get(route('syarat-ketentuan.show'))
            ->assertOk()
            ->assertSee('<script>')
            ->assertDontSee("<script>alert('x')</script>", false);
    }

    public function test_guest_is_redirected_from_admin_terms_page(): void
    {
        $this->get(route('admin.syarat-ketentuan.edit'))
            ->assertRedirect(route('login'));
    }

    public static function rolesWithoutTermsPermission(): array
    {
        return [
            'adopter' => ['adopter'],
            'petugas' => ['petugas'],
        ];
    }

    #[DataProvider('rolesWithoutTermsPermission')]
    public function test_non_admin_roles_cannot_edit_terms(string $role): void
    {
        $this->actingAs($this->user($role))
            ->get(route('admin.syarat-ketentuan.edit'))
            ->assertForbidden();

        $this->put(route('admin.syarat-ketentuan.update'), [
            'content' => 'Konten yang tidak boleh tersimpan oleh pengguna tanpa izin admin.',
        ])->assertForbidden();

        $this->assertDatabaseCount('terms_and_conditions', 0);
    }

    public function test_empty_terms_update_is_rejected_without_saving(): void
    {
        $this->actingAs($this->user('admin'))
            ->from(route('admin.syarat-ketentuan.edit'))
            ->put(route('admin.syarat-ketentuan.update'), ['content' => ''])
            ->assertRedirect(route('admin.syarat-ketentuan.edit'))
            ->assertSessionHasErrors('content');

        $this->assertDatabaseCount('terms_and_conditions', 0);
    }
}
