<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAdRequest;
use App\Services\AdService;

/**
 * AdController
 */
class AdController extends Controller
{
    private $_adService;

    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(AdService $service)
    {
        $this->_adService = $service;
    }
    /**
     * Get all ads
     *
     * @return void
     */
    public function getAllAds()
    {
        return view('layouts/ads', [
            'ads' => $this->_adService->getAds()
        ]);
    }

    /**
     * Get Ad
     *
     * @param  mixed $request
     * @return void
     */
    public function getAd(GetAdRequest $request)
    {
        return view('layouts/parts/ad', [
            'ad' => $this->_adService->getAd($request)
        ]);
    }
}
