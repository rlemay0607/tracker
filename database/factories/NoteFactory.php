<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Meeting;
use App\Models\Note;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'note' => $this->faker->word(),
            'meeting_id' => Meeting::factory(),
        ];
    }
}
