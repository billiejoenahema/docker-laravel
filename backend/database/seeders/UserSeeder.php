<?php

namespace Database\Seeders;

use App\Models\Memo;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'example',
            'email' => 'example@example.com',
            'password' => Hash::make('11111111'),
            'email_verified_at' => now(),
        ]);

        Memo::factory(20)->has(Tag::factory())->create(['user_id' => $user->id]);
    }
}
