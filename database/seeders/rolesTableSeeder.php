<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class rolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id'=>'1',
                'name'=>'administator',
                'description'=>'Super User',
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>'2',
                'name'=>'User',
                'description'=>'Can add expenses',
                'created_at'=>Carbon::now(),
            ]
        ]);
    }
}
