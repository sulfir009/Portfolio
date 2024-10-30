<?php

namespace Database\Factories;

use App\Models\Click;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClickFactory extends Factory
{
    protected $model = Click::class;

    public function definition(): array
    {
        return [
            'binom_click_id' => $this->faker->word(),
            'affise_click_id' => $this->faker->word(),
            'req_id' => $this->faker->word(),
            'cid' => $this->faker->word(),
            'aff_click_id' => $this->faker->word(),
            'aff_id' => $this->faker->word(),
            'subid1' => $this->faker->word(),
            'subid2' => $this->faker->word(),
            'subid3' => $this->faker->word(),
            'is_charged' => $this->faker->boolean(),
            'id_main' => $this->faker->numberBetween(1, 3),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
