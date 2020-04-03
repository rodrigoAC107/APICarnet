<?php

use App\Item;
use App\Role;
use App\User;
use App\Person;
use App\License;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        
        Role::truncate();
        User::truncate();
        License::truncate();
        Person::truncate();
        Item::truncate();
        DB::table('item_license')->truncate();

        $cantidadUsuarios = 10;
        $cantidadPersonas = 40;
        $cantidadCarnet = 25;

        DB::table('roles')->insert([
            'name' => 'Administrado',
            'created_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
            'name' => 'Usuario',
            'created_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
            'name' => 'Jefe',
            'created_at' => Carbon::now()
        ]);

        DB::table('items')->insert([
            'name' => 'Establecimiento',
            'created_at' => Carbon::now()
        ]);
        DB::table('items')->insert([
            'name' => 'Remis',
            'created_at' => Carbon::now()
        ]);
        DB::table('items')->insert([
            'name' => 'Ambulante',
            'created_at' => Carbon::now()
        ]);
        

        factory(User::class, $cantidadUsuarios)->create();
        factory(Person::class, $cantidadPersonas)->create();
        factory(License::class, $cantidadCarnet)->create()->each(
            function($carnet){
                $items = Item::all()->random(mt_rand(1,3))->pluck('id');

                $carnet->items()->attach($items);
            }
        );

        
    }
}
