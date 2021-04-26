<?php

namespace App\Http\Controllers;

use App\Services\AdService;

/**
 * AdController
 */
class AdController extends Controller
{
    /**
     * Get all ads
     *
     * @return void
     */
    public function getAllAds()
    {
        $adService = resolve(AdService::class);
        return $adService->getAds();
    }
}
