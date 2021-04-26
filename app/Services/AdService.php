<?php

namespace App\Services;

use App\Models\Ad;

/**
 * AdService
 */
class AdService
{

    /**
     * Get all ads
     *
     * @return Collection
     */
    public function getAds()
    {
        return Ad::paginate(15);
    }
}
