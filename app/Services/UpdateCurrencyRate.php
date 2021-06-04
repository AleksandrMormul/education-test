<?php

namespace App\Services;

use App\Models\Currency;
use Log;

/**
 * Class UpdateCurrencyRate
 * @package App\Services
 */
class UpdateCurrencyRate
{
    public const CURRENCY_API = 'https://api.exchangerate.host';
    public const DOLLAR = 'USD';
    public const EURO = 'EUR';
    public const UAH = 'UAH';

    /**
     * @param string|null $code
     */
    public static function updateCurrencyRate(string $code = null)
    {
        $currencies = Currency::whereIn('code', [self::DOLLAR, self::EURO, self::UAH]);

        if (!$currencies) {
            Currency::create([
                'name' => 'dollar',
                'code' => self::DOLLAR,
                'rate' => self::convertCurrency(self::DOLLAR, self::UAH),
                'is_default' => false,
            ]);
            Currency::create([
                'name' => 'euro',
                'code' => self::EURO,
                'rate' => self::convertCurrency(self::EURO, self::UAH),
                'is_default' => false,
            ]);
            Currency::create([
                'name' => 'hryvnia',
                'code' => self::UAH,
                'rate' => self::convertCurrency(self::UAH, self::UAH),
                'is_default' => true,
            ]);
        } elseif (!$code) {
            $defaultCurrency = Currency::whereIsDefault(true)->firstOrFail();

            foreach ($currencies->get() as $currency) {
                $currency->update([
                    'rate' => self::convertCurrency($defaultCurrency->code, $currency->code),
                ]);
            }
        }
        if ($code) {
            $defaultCurrency = Currency::whereIsDefault(true)->firstOrFail();
            $currency = Currency::whereCode($code)->firstOrFail();

            switch ($code) {
                case self::DOLLAR:
                    $currency->update([
                        'rate' => self::convertCurrency($defaultCurrency->code, self::DOLLAR),
                    ]);
                    break;
                case self::EURO:
                    $currency->update([
                        'rate' => self::convertCurrency($defaultCurrency->code, self::EURO),
                    ]);
                    break;
                case self::UAH:
                    $currency->update([
                        'rate' => self::convertCurrency($defaultCurrency->code, self::UAH),
                    ]);
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * @param string $typeCurrencyFrom
     * @param string $typeCurrencyTo
     * @return float|int
     */
    public static function convertCurrency(string $typeCurrencyFrom, string $typeCurrencyTo)
    {
        $reqUrl = self::getApiUrl($typeCurrencyFrom, $typeCurrencyTo);
        $responseJson = file_get_contents($reqUrl);
        if (false !== $responseJson) {
            try {
                $response = json_decode($responseJson);
                if ($response->success === true) {
                    return $response->{'result'} * 100;
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    /**
     * @param string $typeCurrencyFrom
     * @param string $typeCurrencyTo
     * @return string
     */
    private static function getApiUrl(string $typeCurrencyFrom, string $typeCurrencyTo): string
    {
        return $typeCurrencyFrom === 'UAH' ?
            self::CURRENCY_API . '/convert?from=' . $typeCurrencyTo . '&to=' . $typeCurrencyFrom . '&amount=1' :
            self::CURRENCY_API . '/convert?from=' . $typeCurrencyFrom . '&to=' . $typeCurrencyTo . '&amount=1';
    }
}
