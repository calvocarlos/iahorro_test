<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class CarlosCalvoTestCommand
 *
 * @package App\Console\Commands
 */
class CarlosCalvoTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cc:t';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando de prueba de Carlos Calvo';

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
        dd("FIN");
    }
}
