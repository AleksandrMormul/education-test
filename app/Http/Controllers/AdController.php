<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ad\GetAdRequest;
use App\Http\Requests\Ad\StoreAdRequest;
use App\Http\Requests\Ad\UpdateAdRequest;
use App\Models\Ad;
use App\Services\AdService;
use App\Services\CountryService;
use App\Services\FavoriteService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

/**
 * Class AdController
 * @package App\Http\Controllers
 */
class AdController extends Controller
{

    /**
     * @var AdService|mixed
     */
    private $adService;

    /**
     * __construct
     *
     * @param AdService $service
     * @return void
     */
    public function __construct(AdService $service)
    {
        $this->adService = $service;
        $this->authorizeResource(Ad::class, 'ad');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $query = $this->adService->getAds();

        return view(
            'ads/index',
            [
                'ads' => $query->paginate(15),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
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
            $imgSrcName = $this->adService->storeAdImage($request->file('ad_file'));
        }
        $adData = $request->getPayload();
        $adId = $this->adService->createAd(array_merge($adData, [
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
        $isFavorite = $this->adService->isFavorite($ad->id);
       // dd($isFavorite);
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
        $adId = $ad->id;
        $imgSrcName = null;
        if ($request->hasFile('ad_file')) {
            $imgSrcName = $this->adService->storeAdImage($request->file('ad_file'));
        }
        $adData = $request->getPayload();
        $this->adService->updateAd($ad, array_merge($adData, [
            'img_src' => $imgSrcName,
        ]));
        return redirect(route('ads.show', $adId));
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
            $this->adService->deleteAd($ad->id);
            return redirect()->route('ads.index')->with('success', 'Deleting ad was success');
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     */
    public function storeFavorite(Request $request)
    {
        $ad = Ad::find($request->input('id'));
        //TODO check if user added to favorite
        $ad->addFavorite();
    }

    /**
     * @param Request $request
     */
    public function destroyFavorite(Request $request)
    {
        $ad = Ad::find($request->input('id'));
        $this->adService->deleteFavorite($ad->id);
    }

    /**
     * @return Application|\Illuminate\Contracts\View\Factory|View
     */
    public function showFavorite()
    {
        $favoriteService = resolve(FavoriteService::class);
        $favoriteService->getFavoriteAds();
        return view('ads.favorite');
    }
}
