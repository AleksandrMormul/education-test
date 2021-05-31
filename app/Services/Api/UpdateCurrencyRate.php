<?php


namespace App\Services\Api;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\CurrencyRate;


/**
 * Class UpdateCurrencyRate
 * @package App\Services\Api
 */
class UpdateCurrencyRate
{
    public const DOLLAR = 'USD';
    public const EURO = 'EUR';
    public const UAH = 'UAH';

    public static function updateCurrencyRate()
    {
        $currencyRate = CurrencyRate::firstOrCreate(self::prepareData());
        $currencyRate->update(self::prepareData());
    }

    /**
     * @param string $typeCurrencyFrom
     * @param string $typeCurrencyTo
     * @param int $amount
     * @return mixed
     */
    private static function convertCurrency(string $typeCurrencyFrom, string $typeCurrencyTo, int $amount = 1)
    {
        return Currency::convert()->from($typeCurrencyFrom)->to($typeCurrencyTo)->amount($amount)->get() * 100;
    }

    /**
     * @return array
     */
    private static function prepareData(): array
    {
        return [
            'dollar' => self::convertCurrency(self::DOLLAR, self::UAH),
            'euro' => self::convertCurrency(self::EURO, self::UAH),
        ];
    }
}
