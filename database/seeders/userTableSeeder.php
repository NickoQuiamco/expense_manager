<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Nicko Quiamco',
            'role_id'=>'1',
            'email'=>'quiamconicko@gmail.com',
            'password'=>bcrypt('password'),
            'created_at'=>Carbon::now(),
        ]);
    }
}
