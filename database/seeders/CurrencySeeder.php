<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Services\UpdateCurrencyRate;
use Illuminate\Database\Seeder;

/**
 * Class CurrencySeeder
 */
class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        if (
            Currency::where('code', [
            UpdateCurrencyRate::UAH,
            UpdateCurrencyRate::EURO,
            UpdateCurrencyRate::DOLLAR,
            ])->doesntExist()
        ) {
            Currency::create([
                'name' => 'hryvnia',
                'code' => UpdateCurrencyRate::UAH,
                'rate' => UpdateCurrencyRate::convertCurrency(UpdateCurrencyRate::UAH, UpdateCurrencyRate::UAH),
                'is_default' => true,
            ]);
            Currency::create([
                'name' => 'dollar',
                'code' => UpdateCurrencyRate::DOLLAR,
                'rate' => UpdateCurrencyRate::convertCurrency(UpdateCurrencyRate::DOLLAR, UpdateCurrencyRate::UAH),
                'is_default' => false,
            ]);
            Currency::create([
                'name' => 'euro',
                'code' => UpdateCurrencyRate::EURO,
                'rate' => UpdateCurrencyRate::convertCurrency(UpdateCurrencyRate::EURO, UpdateCurrencyRate::UAH),
                'is_default' => false,
            ]);
        }
    }
}
