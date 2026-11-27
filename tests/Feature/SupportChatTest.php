<?php

namespace Tests\Feature;

use App\Models\SupportConversation;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportChatTest extends TestCase
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

    public function test_guest_is_redirected_to_login_before_opening_chat(): void
    {
        $this->get(route('chat.index'))
            ->assertRedirect(route('login'));
    }

    public function test_adopter_can_start_and_view_their_support_conversation(): void
    {
        $adopter = $this->user('adopter');

        $this->actingAs($adopter)
            ->post(route('chat.store'), ['message' => 'Halo, saya ingin bertanya.'])
            ->assertRedirect(route('chat.index'));

        $conversation = SupportConversation::where('user_id', $adopter->id)->firstOrFail();

        $this->assertDatabaseHas('support_messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $adopter->id,
            'body' => 'Halo, saya ingin bertanya.',
        ]);

        $this->actingAs($adopter)
            ->get(route('chat.index'))
            ->assertOk()
            ->assertSee('Halo, saya ingin bertanya.')
            ->assertSee('Admin PetHaven')
            ->assertSee('0857-0477-4782')
            ->assertSee('wa.me/6285704774782');
    }

    public function test_adopter_can_only_see_their_own_messages(): void
    {
        $owner = $this->user('adopter');
        $other = $this->user('adopter');

        $this->actingAs($owner)->post(route('chat.store'), ['message' => 'Pesan milik saya.']);
        $this->actingAs($other)->post(route('chat.store'), ['message' => 'Pesan pribadi orang lain.']);

        $this->actingAs($owner)
            ->get(route('chat.index'))
            ->assertOk()
            ->assertSee('Pesan milik saya.')
            ->assertDontSee('Pesan pribadi orang lain.');
    }

    public function test_customer_message_content_is_escaped_when_displayed(): void
    {
        $adopter = $this->user('adopter');
        $message = "<script>alert('x')</script>";

        $this->actingAs($adopter)->post(route('chat.store'), ['message' => $message]);

        $this->get(route('chat.index'))
            ->assertOk()
            ->assertSee('<script>')
            ->assertDontSee($message, false);
    }

    public function test_admin_can_read_customer_messages_and_reply(): void
    {
        $adopter = $this->user('adopter');
        $this->actingAs($adopter)->post(route('chat.store'), ['message' => 'Apakah hewannya sudah divaksin?']);
        $conversation = SupportConversation::where('user_id', $adopter->id)->firstOrFail();

        $admin = $this->user('admin');
        $this->actingAs($admin)
            ->get(route('admin.chat.index'))
            ->assertOk()
            ->assertSee($adopter->name)
            ->assertSee('1 pesan');

        $this->get(route('admin.chat.show', $conversation))
            ->assertOk()
            ->assertSee('Apakah hewannya sudah divaksin?');

        $this->post(route('admin.chat.store', $conversation), ['message' => 'Sudah, vaksin lengkap.'])
            ->assertRedirect(route('admin.chat.show', $conversation));

        $this->assertDatabaseHas('support_messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $admin->id,
            'body' => 'Sudah, vaksin lengkap.',
        ]);

        $this->actingAs($adopter)
            ->get(route('chat.index'))
            ->assertOk()
            ->assertSee('Sudah, vaksin lengkap.');
    }

    public function test_adopter_cannot_open_admin_chat_inbox(): void
    {
        $this->actingAs($this->user('adopter'))
            ->get(route('admin.chat.index'))
            ->assertForbidden();
    }

    public function test_petugas_cannot_access_customer_conversations_or_reply(): void
    {
        $adopter = $this->user('adopter');
        $this->actingAs($adopter)->post(route('chat.store'), ['message' => 'Pertanyaan pelanggan.']);
        $conversation = SupportConversation::where('user_id', $adopter->id)->firstOrFail();
        $petugas = $this->user('petugas');

        $this->actingAs($petugas)
            ->get(route('admin.chat.index'))
            ->assertForbidden();

        $this->get(route('admin.chat.show', $conversation))
            ->assertForbidden();

        $this->post(route('admin.chat.store', $conversation), ['message' => 'Balasan yang tidak diizinkan.'])
            ->assertForbidden();

        $this->assertDatabaseMissing('support_messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $petugas->id,
        ]);
    }

    public function test_message_is_required_and_limited_to_2000_characters(): void
    {
        $adopter = $this->user('adopter');

        $this->actingAs($adopter)
            ->post(route('chat.store'), ['message' => ''])
            ->assertSessionHasErrors('message');

        $this->post(route('chat.store'), ['message' => str_repeat('a', 2001)])
            ->assertSessionHasErrors('message');

        $this->assertDatabaseCount('support_conversations', 0);
        $this->assertDatabaseCount('support_messages', 0);
    }
}
