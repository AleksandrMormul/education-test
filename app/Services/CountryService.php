<?php

namespace App\Services;

use Countries;
use Illuminate\Support\Facades\Lang;

/**
 * Class CountryService
 * @package App\Services
 */
class CountryService
{

    /**
     * @return mixed
     */
    public static function getAllCountry()
    {
        return Countries::getList(Lang::getLocale());
    }
}
