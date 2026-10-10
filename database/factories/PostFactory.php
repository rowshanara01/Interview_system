<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'title'   => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];
    }
}
