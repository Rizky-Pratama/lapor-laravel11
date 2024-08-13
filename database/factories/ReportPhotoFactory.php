<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportPhoto>
 */
class ReportPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $image = $this->faker->image();
        $namePhoto = Storage::disk('public')->putFile('photos', $image);
        return [
            'report_id' => Report::factory(),
            'photo_path' => $namePhoto,
        ];
    }
}
