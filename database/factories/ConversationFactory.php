<?php
namespace Database\Factories;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition()
    {
        return [
            'body' => $this->faker->paragraph,
            'attachment' => null,
            'is_read' => $this->faker->boolean,
            'from_id' => \App\Models\User::inRandomOrder()->first()?->id,
            'to_id' => \App\Models\User::inRandomOrder()->first()?->id,
        ];
    }
}
