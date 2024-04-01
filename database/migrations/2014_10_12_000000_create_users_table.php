<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('avatar');
            $table->rememberToken();
            $table->timestamps();
        });
        User::create([
            'username' => 'admin',
            'name' => 'Mohd Hazizi',
            'email' => 'pentadbirmuet@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => '2023-01-01 00:00:00',
            'avatar' => 'avatar-1.jpg',
            'created_at' => now(),
        ]);
        User::create([
            'username' => '000000000000',
            'name' => 'Mohd Hazizi',
            'email' => 'calonmuet@gmail.com',
            'password' => Hash::make('000000000000'),
            'email_verified_at' => '2023-01-01 00:00:00',
            'avatar' => 'avatar-1.jpg',
            'created_at' => now(),
        ]);
        User::create([
            'username' => 'modadmin',
            'name' => 'MOD-ADMIN',
            'email' => 'modadmin@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => '2023-01-01 00:00:00',
            'avatar' => 'avatar-1.jpg',
            'created_at' => now(),
        ]);
        User::create([
            'username' => 'muetadmin',
            'name' => 'MUET-ADMIN',
            'email' => 'muetadmin@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => '2023-01-01 00:00:00',
            'avatar' => 'avatar-1.jpg',
            'created_at' => now(),
        ]);
        User::create([
            'username' => 'bpcomadmin',
            'name' => 'BPCOM-ADMIN',
            'email' => 'bpcomadmin@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => '2023-01-01 00:00:00',
            'avatar' => 'avatar-1.jpg',
            'created_at' => now(),
        ]);
        User::create([
            'username' => 'psmadmin',
            'name' => 'PSM-ADMIN',
            'email' => 'psmadmin@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => '2023-01-01 00:00:00',
            'avatar' => 'avatar-1.jpg',
            'created_at' => now(),
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
