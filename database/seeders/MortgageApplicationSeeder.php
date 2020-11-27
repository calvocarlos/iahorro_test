<?php

namespace Database\Seeders;

use App\Models\MortgageApplication;
use Illuminate\Database\Seeder;

/**
 * Class MortgageApplicationSeeder
 *
 * @package Database\Seeders
 */
class MortgageApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MortgageApplication::factory()->times(50)->create();
    }
}
