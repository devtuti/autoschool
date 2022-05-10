<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name_familya'=>'Turkan Mammadli',
            'email'=>'tuti92@mail.ru',
            'password'=>bcrypt(192807),
            'phone'=>287946,
            'grade'=>1,
            'status'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
