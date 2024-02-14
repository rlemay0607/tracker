<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ActionItem;
use App\Models\Contact;
use App\Models\Meeting;

class ActionItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActionItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'action' => $this->faker->word(),
            'due_date' => $this->faker->date(),
            'status' => $this->faker->word(),
            'title' => $this->faker->sentence(4),
            'meeting_id' => Meeting::factory(),
            'contact_id' => Contact::factory(),
        ];
    }
}
