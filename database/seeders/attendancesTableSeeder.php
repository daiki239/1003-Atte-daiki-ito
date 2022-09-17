<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class attendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     $param = [
            'name' => 'tony',
        ];
        attendance::create($param);
        $param = [
            'name' => 'jack',
        ];
        attendance::create($param);
        $param = [
            'name' => 'sara',
        ];
        attendance::create($param);
        $param = [
            'name' => 'saly',
        ];
        attendance::create($param);
    }
}
