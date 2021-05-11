<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Database\Query\Builder;

/**
 * AdService
 */
class AdService
{

    /**
     * Get all ads
     *
     * @return Builder
     */
    public function getAds()
    {
        return Ad::query();
    }
}
