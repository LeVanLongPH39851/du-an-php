<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;

    public function generateRandomPassword($length = 8)
    {
       $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $lowerCase = 'abcdefghijklmnopqrstuvwxyz';
       $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';
       $numbers = '0123456789';

       $allCharacters = $upperCase . $lowerCase . $numbers . $specialChars;

       $password = [];
       $password[] = $upperCase[rand(0, strlen($upperCase) - 1)];
       $password[] = $lowerCase[rand(0, strlen($lowerCase) - 1)];
       $password[] = $specialChars[rand(0, strlen($specialChars) - 1)];
       $password[] = $numbers[rand(0, strlen($numbers) - 1)];

       for ($i = 4; $i < $length; $i++) {
         $password[] = $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }

    shuffle($password);

    return implode('', $password);
    }

    public function definition(): array
    {
        $mat_khau = $this->generateRandomPassword();
        return [
            'ma_khach_hang' => "KH-".Str::random(6),
            'name' => fake()->name(),
            'so_dien_thoai' => fake()->phoneNumber,
            'email' => fake()->unique()->safeEmail(),
            'dia_chi' => fake()->address,
            "mat_khau" => $mat_khau,
            'email_verified_at' => now(),
            'password' => Hash::make($mat_khau),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}