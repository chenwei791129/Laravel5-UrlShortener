<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'demo';
        $user->email = 'example@domain.com';
        $user->password = bcrypt('P@ssw0rd');
        $user->save();
    }
}
