<?php

namespace YourVendor\FakeInbox\Database\Factories;

use YourVendor\FakeInbox\Models\InboxEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\YourVendor\FakeInbox\Models\InboxEmail>
 */
class InboxEmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InboxEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'inbox_id' => \YourVendor\FakeInbox\Models\Inbox::factory(),
            'message_id' => $this->faker->unique()->uuid,
            'subject' => $this->faker->sentence,
            'from' => [['email' => $this->faker->email, 'name' => $this->faker->name]],
            'to' => [['email' => $this->faker->email, 'name' => $this->faker->name]],
            'html_body' => $this->faker->randomHtml(),
            'text_body' => $this->faker->text,
            'raw_body' => $this->faker->text,
            'headers' => $this->faker->text,
            'is_spam' => false,
            'spam_score' => 0,
        ];
    }
}