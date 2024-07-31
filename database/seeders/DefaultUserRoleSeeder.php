<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::truncate();
        // Role::truncate();

        $role = Role::create([
            'name' => 'CALON',
            'guard_name' => 'candidate', // Specify the guard name here
        ]);
        $role = Role::create(['name' => 'PENTADBIR']);
        $role = Role::create(['name' => 'PSM']); //handle muet biasa
        $role = Role::create(['name' => 'BPKOM']); //handle muet on demand
        $role = Role::create(['name' => 'FINANCE']);


        // $user = new User();
        // $user->name = 'Mohd Hazizi';
        // $user->email = 'pentadbirmuet@gmail.com';
        // $user->password = Hash::make('123456');

        // $user->email_verified_at = '2023-01-01 00:00:00';
        // $user->avatar = 'avatar-1.jpg';
        // $user->created_at = now();
        // $user->save();
        // $user->assignRole('PENTADBIR');

        // $user = new User();
        // $user->name = 'MOD-ADMIN';
        // $user->email = 'modadmin@gmail.com';
        // $user->password = Hash::make('123456');

        // $user->email_verified_at = '2023-01-01 00:00:00';
        // $user->avatar = 'avatar-1.jpg';
        // $user->created_at = now();
        // $user->save();
        // $user->assignRole('BPKOM');

        // $user = new User();
        // $user->name = 'MUET-ADMIN';
        // $user->email = 'muetadmin@gmail.com';
        // $user->password = Hash::make('123456');

        // $user->email_verified_at = '2023-01-01 00:00:00';
        // $user->avatar = 'avatar-1.jpg';
        // $user->created_at = now();
        // $user->save();
        // $user->assignRole('PSM');

        // $user = new User();
        // $user->name = 'FINANCE';
        // $user->email = 'finance@gmail.com';
        // $user->password = Hash::make('123456');

        // $user->email_verified_at = '2023-01-01 00:00:00';
        // $user->avatar = 'avatar-1.jpg';
        // $user->created_at = now();
        // $user->save();
        // $user->assignRole('FINANCE');

        $arr = [
            'PENTADBIR',
            'PENTADBIR',
            'BPKOM',
            'BPKOM',
            'PSM',
            'PSM',
            'FINANCE',
            'FINANCE',
        ];

        foreach ($arr as $key => $value) {
            $user = new User();
            $user->name = 'User'.($key+1);
            $user->email = 'user'.($key+1).'@mail.com';
            $user->password = Hash::make('123456');
            $user->email_verified_at = '2023-01-01 00:00:00';
            $user->avatar = 'avatar-1.jpg';
            $user->created_at = now();
            $user->save();
            $user->assignRole($value);
        }

    }
}
