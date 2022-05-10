<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Intiqam Mammadli',
            'email'=>'intiqam93@mail.ru',
            'password'=>bcrypt(23081993),
            'teacher_id'=>1,
            'status'=>0,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
