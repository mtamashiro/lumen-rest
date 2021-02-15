<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        for($x = 0; $x < 25; $x++){
            $id = DB::table('natural_persons')->insertGetId([
                'cpf' => Str::random(10),
            ]);

            $id = DB::table('users')->insertGetId([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make(Str::random(10)),
                'person_type' => 'Domain\User\Models\NaturalPerson',
                'person_id' => $id,
            ]);

            DB::table('accounts')->insert([
                'user_id' => $id,
                'amount' => rand(0,100000),
            ]);
        }

        for($x = 0; $x < 25; $x++){
            $id = DB::table('juridical_persons')->insertGetId([
                'cnpj' => Str::random(10),
            ]);

            $id = DB::table('users')->insertGetId([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make(Str::random(10)),
                'person_type' => 'Domain\User\Models\JuridicalPerson',
                'person_id' => $id,
            ]);

            DB::table('accounts')->insert([
                'user_id' => $id,
                'amount' => rand(0,100000),
            ]);
        }
    }
}
