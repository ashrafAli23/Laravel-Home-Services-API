<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Service::class;


    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words($nb = 4, $asText = true),
            'slug' => Str::slug($this->faker->unique()->words($nb = 4, $asText = true), "-"),
            'tagline' => $this->faker->text(20),
            'service_category_id' => 1,
            'price' => $this->faker->numberBetween(100, 500),
            'discount_type' => "fixed",
            'image' => $this->faker->unique()->numberBetween(1, 20) . '.jpg',
            'description' => $this->faker->text(200),
            'inclusion' => $this->faker->text(20) . "|" . $this->faker->text(20),
            'exclusion' => $this->faker->text(20) . "|" . $this->faker->text(20),

        ];
    }
}
