<?php

namespace App\Services;

use App\Http\Requests\GetAdRequest;
use App\Models\Ad;
use App\Models\User;

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

    /**
     * Get Ad
     *
     * @param  mixed $request
     * @return void
     */
    public function getAd(GetAdRequest $request)
    {
        return Ad::find($request->id)->user();
    }
}
