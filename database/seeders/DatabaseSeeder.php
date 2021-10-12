<?php

namespace Database\Seeders;

use App\Models\Avatar;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id'=>1,
            'username'=>'admin',
            'password'=>Hash::make('123456'),
            'status'=>'active',
        ]);
        $role = UserRole::create([
            'id'=>1,
            'user_id'=>1,
            'name'=>"admin",
        ]);
        $infos = UserInfo::create([
            'id'=>1,
            'user_id'=>1,
            'first_name'=>"John",
            'last_name'=>"Doe",
            'email'=>"john@app.com",
            'phone'=>"0177777",
            'dob'=>"1994-10-17",
            'gender'=>"male",
        ]);
        $avatars = Avatar::create([
            'id'=>1,
            'user_id'=>1,
            'link'=>env('APP_URL')."/storage/avatars/1/admin.png",
            'path'=>"/storage/avatars/1/admin.png",
        ]);
    }
}
