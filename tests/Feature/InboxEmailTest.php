<?php

namespace YourVendor\FakeInbox\Tests\Feature;

use YourVendor\FakeInbox\Models\Inbox;
use YourVendor\FakeInbox\Models\InboxEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InboxEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_emails_in_inbox()
    {
        $user = \App\Models\User::factory()->create();
        $inbox = Inbox::factory()->create(['user_id' => $user->id]);
        $emails = InboxEmail::factory()->count(5)->create(['inbox_id' => $inbox->id]);

        $response = $this->actingAs($user)
            ->get(route('fake-inbox.emails.index', $inbox));

        $response->assertOk();
        $emails->each(function ($email) use ($response) {
            $response->assertSee($email->subject);
        });
    }

    /** @test */
    public function user_can_view_single_email()
    {
        $user = \App\Models\User::factory()->create();
        $inbox = Inbox::factory()->create(['user_id' => $user->id]);
        $email = InboxEmail::factory()->create(['inbox_id' => $inbox->id]);

        $response = $this->actingAs($user)
            ->get(route('fake-inbox.emails.show', [$inbox, $email]));

        $response->assertOk()
            ->assertSee($email->subject)
            ->assertSee($email->from[0]['email']);
    }

    /** @test */
    public function email_is_marked_as_read_when_viewed()
    {
        $user = \App\Models\User::factory()->create();
        $inbox = Inbox::factory()->create(['user_id' => $user->id]);
        $email = InboxEmail::factory()->create([
            'inbox_id' => $inbox->id,
            'read_at' => null
        ]);

        $this->actingAs($user)
            ->get(route('fake-inbox.emails.show', [$inbox, $email]));

        $this->assertNotNull($email->fresh()->read_at);
    }
}