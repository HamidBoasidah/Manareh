<?php
namespace Database\Factories;

use App\Models\ContentBlock;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentBlockFactory extends Factory
{
    protected $model = ContentBlock::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['info','contact','about','other']),
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->text(500),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'whatsapp_url' => $this->faker->url,
            'whatsapp_label' => $this->faker->word,
            'phone_number' => $this->faker->phoneNumber,
            'phone_label' => $this->faker->word,
            'attachment' => null,
            'is_active' => true,
            'created_by' => \App\Models\User::inRandomOrder()->first()?->id,
            'updated_by' => \App\Models\User::inRandomOrder()->first()?->id,
        ];
    }
}
