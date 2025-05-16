<?php

namespace YourVendor\FakeInbox\Database\Factories;

use YourVendor\FakeInbox\Models\Inbox;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\YourVendor\FakeInbox\Models\Inbox>
 */
class InboxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inbox::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'user_id' => \App\Models\User::factory(),
            'settings' => [
                'forwarding_enabled' => false,
                'max_emails' => 1000,
                'retention_days' => 30,
            ],
        ];
    }
}