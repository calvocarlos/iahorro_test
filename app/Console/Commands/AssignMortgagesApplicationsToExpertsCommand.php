<?php

namespace App\Console\Commands;

use App\Models\MortgageApplication;
use Illuminate\Console\Command;

/**
 * Class AssignMortgagesApplicationsToExpertsCommand
 *
 * @package App\Console\Commands
 */
class AssignMortgagesApplicationsToExpertsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iahorro:assign_mortgage_applications_to_mortgage_experts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asigna las solicitudes a los expertos segun el Scoring';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        MortgageApplication::assignMortgageApplicationsToMortgageExperts();
    }
}
