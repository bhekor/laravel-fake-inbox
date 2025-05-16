<?php

namespace YourVendor\FakeInbox\Tests\Feature;

use YourVendor\FakeInbox\Models\Inbox;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InboxTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_inbox()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('fake-inbox.inboxes.store'), [
                'name' => 'Test Inbox'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inboxes', [
            'name' => 'Test Inbox',
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function inbox_name_is_required()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('fake-inbox.inboxes.store'), [
                'name' => ''
            ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_can_view_their_inboxes()
    {
        $user = \App\Models\User::factory()->create();
        $inboxes = Inbox::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('fake-inbox.inboxes.index'));

        $response->assertOk();
        $inboxes->each(function ($inbox) use ($response) {
            $response->assertSee($inbox->name);
        });
    }
}