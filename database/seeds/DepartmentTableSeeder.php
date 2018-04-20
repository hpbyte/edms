<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dept1 = new Department();
        $dept1->dptName = 'CEIT';
        $dept1->save();

        $dept2 = new Department();
        $dept2->dptName = 'EC';
        $dept2->save();

        $dept3 = new Department();
        $dept3->dptName = 'McE';
        $dept3->save();
    }
}
