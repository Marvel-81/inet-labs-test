<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'comment' => $this->faker->sentence,
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'updated_at' => now(),
        ];
    }

    public function withAiAnalysis()
    {
        return $this->afterCreating(function (Lead $lead) {
            $lead->aiAnalysis()->createMany([
                [
                    'parameter' => 'Тональность',
                    'decoded_value' => 'Нейтральная тональность',
                ],
                [
                    'parameter' => 'Намерение',
                    'decoded_value' => 'Покупка',
                ],
            ]);
        });
    }
}
