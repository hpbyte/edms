<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p1 = Permission::create(['name' => 'root']);
        $p2 = Permission::create(['name' => 'manage']);
        $p3 = Permission::create(['name' => 'read']);
        $p4 = Permission::create(['name' => 'edit']);
        $p5 = Permission::create(['name' => 'delete']);
        $p6 = Permission::create(['name' => 'upload']);
        $p7 = Permission::create(['name' => 'download']);
        $p8 = Permission::create(['name' => 'shared']);
    }
}
