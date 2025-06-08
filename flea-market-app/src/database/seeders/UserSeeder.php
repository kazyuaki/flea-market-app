<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // パスワードはハッシュ化が必要
            'post_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building_name' => 'テックビル301',
            'is_profile_set' => true,
        ]);
    
    }
}
