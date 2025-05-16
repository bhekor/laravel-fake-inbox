<?php

namespace YourVendor\FakeInbox\Tests\Feature\Api;

use YourVendor\FakeInbox\Models\Inbox;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InboxApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_inboxes()
    {
        $user = \App\Models\User::factory()->create();
        $inboxes = Inbox::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson('/api/fake-inbox/inboxes');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'created_at']
                ]
            ]);
    }

    /** @test */
    public function it_can_create_inbox()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/fake-inbox/inboxes', [
                'name' => 'Test Inbox',
                'forwarding_enabled' => true
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Test Inbox')
            ->assertJsonPath('data.settings.forwarding_enabled', true);
    }

    /** @test */
    public function it_shows_specific_inbox()
    {
        $user = \App\Models\User::factory()->create();
        $inbox = Inbox::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson("/api/fake-inbox/inboxes/{$inbox->id}");

        $response->assertOk()
            ->assertJsonPath('data.id', $inbox->id);
    }
}