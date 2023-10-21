<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        User::insert([
            [
                'name'=>'CrudCartelera',
                'email'=>'crudcartelera@crudcartelera.com',
                'password'=> Hash::make('gn?BFw5C27J@8Ksm@')
            ]
        ]);
    }
}
