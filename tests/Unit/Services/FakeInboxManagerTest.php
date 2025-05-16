<?php

namespace YourVendor\FakeInbox\Tests\Unit\Services;

use YourVendor\FakeInbox\Models\Inbox;
use YourVendor\FakeInbox\Services\FakeInboxManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FakeInboxManagerTest extends TestCase
{
    use RefreshDatabase;

    private FakeInboxManager $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->manager = new FakeInboxManager();
    }

    /** @test */
    public function it_can_enable_and_disable_interception()
    {
        $this->assertFalse($this->manager->isEnabled());

        $this->manager->enable();
        $this->assertTrue($this->manager->isEnabled());

        $this->manager->disable();
        $this->assertFalse($this->manager->isEnabled());
    }

    /** @test */
    public function it_returns_default_inbox_for_current_user()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $inbox = $this->manager->getCurrentInbox();

        $this->assertInstanceOf(Inbox::class, $inbox);
        $this->assertEquals('Default Inbox', $inbox->name);
        $this->assertEquals($user->id, $inbox->user_id);
    }

    /** @test */
    public function it_can_set_current_inbox()
    {
        $user = \App\Models\User::factory()->create();
        $inbox = Inbox::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $this->manager->setCurrentInbox($inbox);

        $this->assertEquals($inbox->id, $this->manager->getCurrentInbox()->id);
    }
}