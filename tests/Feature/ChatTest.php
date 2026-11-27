<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
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

    public function test_admin_broadcasts_and_users_can_reply_in_two_way_chat(): void
    {
        $admin = $this->user('admin');
        $staff = $this->user('petugas');
        $adopter = $this->user('adopter');
        $seller = $this->user('adopter');
        $seller->assignRole('seller');

        $this->actingAs($admin)->post(route('admin.chat.broadcast'), [
            'body' => 'Pengumuman jadwal adopsi akhir pekan.',
        ])->assertSessionHasNoErrors();

        $this->assertSame(2, Conversation::count());
        $this->actingAs($admin)->get(route('admin.chat.index'))->assertOk()->assertSee($adopter->name);
        $this->assertDatabaseHas('messages', [
            'sender_id' => $admin->id,
            'body' => 'Pengumuman jadwal adopsi akhir pekan.',
        ]);
        $this->assertDatabaseMissing('conversations', ['user_id' => $staff->id]);

        $this->actingAs($adopter)->get(route('chat.index'))
            ->assertOk()
            ->assertSee('Pengumuman jadwal adopsi akhir pekan.');

        $this->post(route('chat.store'), ['body' => 'Terima kasih atas informasinya.'])
            ->assertRedirect(route('chat.index'));

        $conversation = $adopter->fresh()->conversation;
        $this->actingAs($admin)->get(route('admin.chat.show', $conversation))
            ->assertOk()
            ->assertSee('Terima kasih atas informasinya.');

        $this->post(route('admin.chat.store', $conversation), ['body' => 'Sama-sama, sampai bertemu.'])
            ->assertSessionHasNoErrors();

        $this->actingAs($adopter)->get(route('chat.index'))
            ->assertOk()
            ->assertSee('Sama-sama, sampai bertemu.');
        $this->assertSame(3, Message::where('conversation_id', $conversation->id)->count());
    }

    public function test_petugas_and_adopter_cannot_access_admin_chat(): void
    {
        $this->actingAs($this->user('petugas'))->get(route('admin.chat.index'))->assertForbidden();
        $this->actingAs($this->user('adopter'))->get(route('admin.chat.index'))->assertForbidden();
    }
}
