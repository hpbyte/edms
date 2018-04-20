<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $root = new User();
        $root->name = 'Wade Wilson';
        $root->email = 'deadp00l@gmail.com';
        $root->password = 'deadp00l';
        $root->status = true;
        $root->save();

        $admin = new User();
        $admin->name = 'Tony Stark';
        $admin->email = 'ir0nman@gmail.com';
        $admin->password = 'ir0nman';
        $admin->department_id = '1';
        $admin->status = true;
        $admin->save();

        $user = new User();
        $user->name = 'Steve Rogers';
        $user->email = 'captain@gmail.com';
        $user->password = 'captain';
        $user->department_id = '2';
        $user->status = true;
        $user->save();
    }
}
