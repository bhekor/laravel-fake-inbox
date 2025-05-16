<?php

namespace YourVendor\FakeInbox\Tests\Feature\Api;

use YourVendor\FakeInbox\Models\Inbox;
use YourVendor\FakeInbox\Models\InboxEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InboxEmailApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_emails_for_inbox()
    {
        $user = \App\Models\User::factory()->create();
        $inbox = Inbox::factory()->create(['user_id' => $user->id]);
        $emails = InboxEmail::factory()->count(5)->create(['inbox_id' => $inbox->id]);

        $response = $this->actingAs($user)
            ->getJson("/api/fake-inbox/inboxes/{$inbox->id}/emails");

        $response->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'subject', 'from', 'created_at']
                ]
            ]);
    }

    /** @test */
    public function it_can_show_specific_email()
    {
        $user = \App\Models\User::factory()->create();
        $inbox = Inbox::factory()->create(['user_id' => $user->id]);
        $email = InboxEmail::factory()->create(['inbox_id' => $inbox->id]);

        $response = $this->actingAs($user)
            ->getJson("/api/fake-inbox/inboxes/{$inbox->id}/emails/{$email->id}");

        $response->assertOk()
            ->assertJsonPath('data.id', $email->id)
            ->assertJsonPath('data.subject', $email->subject);
    }

    /** @test */
    public function it_can_forward_email()
    {
        $user = \App\Models\User::factory()->create();
        $inbox = Inbox::factory()->create(['user_id' => $user->id]);
        $email = InboxEmail::factory()->create(['inbox_id' => $inbox->id]);

        $response = $this->actingAs($user)
            ->postJson("/api/fake-inbox/inboxes/{$inbox->id}/emails/{$email->id}/forward", [
                'recipient' => 'test@example.com'
            ]);

        $response->assertOk()
            ->assertJson(['message' => 'Email has been queued for forwarding']);
    }
}