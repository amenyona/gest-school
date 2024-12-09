<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();
        $admin = User::create([
            'uuid' => (string)Str::uuid(),
            'user_creator_id' => 1,
            'lieu_id' => 1,
            'name' => 'LATE',
            'firstname' => 'Edem',
            'birthdate' =>'09/09/1989',
            'phone' => '45123256',
            'image' =>NULL,
            'sexe' =>'masculin',
            'online' =>'oui',
            'email' => 'late@late.com',
            'etat' => 'on',
            'signature' => NULL,
            'password' => Hash::make('password')
        ]);

        $surveillant = User::create([
            'uuid' => (string)Str::uuid(),
            'user_creator_id' => 1,
            'lieu_id' => 1,
            'name' => 'ATTIOGBE',
            'firstname' => 'Simplice',
            'birthdate' =>'09/09/1999',
            'phone' => '969696969',
            'image' => NULL,
            'sexe' => 'masculin',
            'online' =>'non',
            'email' => 'attiogbe@attiogbe.com',
            'password' => Hash::make('password')
        ]);

        $secretaire = User::create([
            'uuid' => (string)Str::uuid(),
            'user_creator_id' => 1,
            'lieu_id' => 1,
            'name' => 'AKAKPO',
            'firstname' => 'Augustine',
            'birthdate' =>'09/09/1989',
            'phone' => '23524163',
            'image' => NULL,
            'sexe' => 'feminin',
            'online' => 'non',
            'email' => 'akakpo@akakpo.com',
            'password' => Hash::make('password')
        ]);

        $adminRole = Role::where('name','admin')->first();
        $surveillantRole = Role::where('name','surveillant')->first();
        $secretaireRole = Role::where('name','secretaire')->first();

        $admin->roles()->attach($adminRole);
        $surveillant->roles()->attach($surveillantRole);
        $secretaire->roles()->attach($secretaireRole);
    }
}
