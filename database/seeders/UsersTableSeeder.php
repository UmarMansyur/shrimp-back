<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Khana Zulfana Imam',
            'email'=> 'Khana@unira.ac.id',
            'password' => Hash::make('123'),
        ]);
        UserDetail::create([
            'user_id' => $user->id,
            'address' => 'Jl. Raya Kedungkandang No. 1, Kedungkandang, Kec. Kedungkandang, Kota Malang, Jawa Timur 65151',
            'phone' => '081234567890'
        ]);
    }
}
