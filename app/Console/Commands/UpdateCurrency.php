<?php

namespace App\Console\Commands;

use App\Services\Api\UpdateCurrencyRate;
use Illuminate\Console\Command;

/**
 * Class UpdateCurrency
 * @package App\Console\Commands
 */
class UpdateCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:currency-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will updating current currency rate';

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
     *
     * @return void
     */
    public function handle()
    {
        UpdateCurrencyRate::updateCurrencyRate();
    }
}
