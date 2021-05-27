<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ad\GetAdRequest;
use App\Http\Requests\Ad\IndexAdRequest;
use App\Http\Requests\Ad\StoreAdRequest;
use App\Http\Requests\Ad\UpdateAdRequest;
use App\Models\Ad;
use App\Services\AdService;
use App\Services\CountryService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

/**
 * Class AdController
 * @package App\Http\Controllers
 */
class AdController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Ad::class, 'ad');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexAdRequest $request
     * @return Renderable
     */
    public function index(IndexAdRequest $request): Renderable
    {
        if ($request->getFavorites() && auth()->user()) {
            $query = AdService::getFavoritesForUser($request->user());
            $ads = $query->paginate(15);

            if (count($ads) === 0) {
                return view('ads.favorite');
            }
        } else {
            $query = AdService::getAds();
            $ads = $query->paginate(15);
            if (auth()->user()) {
                foreach ($ads as $ad) {
                    $ad['isFavorite'] = $ad->isFavoriteForUser($request->user());
                }
            }
        }

        return view(
            'ads/index',
            [
                'ads' => $ads,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $countries = CountryService::getAllCountry();

        return view('ads/create', ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(StoreAdRequest $request)
    {
        $imgSrcName = null;

        if ($request->file('ad_file')) {
            $imgSrcName = AdService::storeAdImage($request->file('ad_file'));
        }

        $adData = $request->getPayload();
        $adId = AdService::createAd(array_merge($adData, [
            'img_src' => $imgSrcName,
        ]));

        return redirect(route('ads.show', $adId));
    }

    /**
     * Display the specified resource.
     *
     * @param GetAdRequest $request
     * @param Ad $ad
     * @return Renderable
     */
    public function show(GetAdRequest $request, Ad $ad): Renderable
    {
        $user = $request->user();
        $isFavorite = null;
        if ($user) {
            $isFavorite = $ad->isFavoriteForUser($user);
        }

        return view('ads/show', [
            'ad' => $ad,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ad $ad
     * @return Renderable
     */
    public function edit(Ad $ad): Renderable
    {
        $countries = CountryService::getAllCountry();

        return view('ads.edit', [
            'ad' => $ad,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdRequest $request
     * @param Ad $ad
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateAdRequest $request, Ad $ad)
    {
        $imgSrcName = null;

        if ($request->hasFile('ad_file')) {
            $imgSrcName = AdService::storeAdImage($request->file('ad_file'));
        }

        $adData = $request->getPayload();
        AdService::updateAd($ad, array_merge($adData, [
            'img_src' => $imgSrcName,
        ]));

        return redirect(route('ads.show', $ad->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Ad $ad
     * @return RedirectResponse
     */
    public function destroy(Request $request, Ad $ad): RedirectResponse
    {
        try {
            AdService::deleteAd($ad);

            return redirect()->route('ads.index')->with('success', 'Deleting ad was success');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
