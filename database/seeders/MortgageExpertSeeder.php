<?php

namespace Database\Seeders;

use App\Models\MortgageExpert;
use Illuminate\Database\Seeder;

/**
 * Class MortgageExpertSeeder
 *
 * @package Database\Seeders
 */
class MortgageExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MortgageExpert::create(['first_name' => 'Pedro', 'last_name' => 'Picapiedras']);
        MortgageExpert::create(['first_name' => 'Pablo', 'last_name' => 'Marmol']);
        MortgageExpert::factory()->times(3)->create();
    }
}
