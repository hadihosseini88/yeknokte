<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static $seeders=[];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$seeders as $seeder) {
            $this->call($seeder);
        }
        // $this->call(RolePermissionTableSeeder::class);
    }
}
