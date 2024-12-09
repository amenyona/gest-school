<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Str;

use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create([
            'uuid' => (string)Str::uuid(),
            'name'=>'admin',
            'description' =>'Compte administrateur'
        ]);


        Role::create([
            'uuid' => (string)Str::uuid(),
            'name' => 'surveillant',
            'description' => 'compte surveillant'
        ]);

        Role::create([
            'uuid' => (string)Str::uuid(),
            'name' => 'secretaire',
            'description' => 'compte secretaire'
        ]); 
        Role::create([
            'uuid' => (string)Str::uuid(),
            'name' => 'Elève',
            'description' => 'compte Elève'
        ]); 
        Role::create([
            'uuid' => (string)Str::uuid(),
            'name' => 'Tuteur/Parent',
            'description' => 'Tuteur/Parent'
        ]); 
     

    }
}
