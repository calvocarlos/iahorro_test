<?php

namespace Database\Seeders;

use App\Models\MortgageExpert;
use App\Models\MortgageApplication;
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
        $this->truncateTables([
            app(MortgageApplication::class)->getTable(),
            app(MortgageExpert::class)->getTable(),
        ]);

        $this->call([
            MortgageApplicationSeeder::class,
            MortgageExpertSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }

    /**
     * Elimina el contenido de las tablas para la migración
     *
     * @param  array  $tables
     */
    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
