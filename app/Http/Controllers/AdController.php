<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ad\GetAdRequest;
use App\Http\Requests\Ad\StoreAdRequest;
use App\Http\Requests\Ad\UpdateAdRequest;
use App\Models\Ad;
use App\Services\AdService;
use App\Services\CountryService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
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
                'ads' => $query->adByDate()->paginate(15),
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
        $counties = CountryService::getAllCountry();
        return view('ads/create', ['countries' => $counties]);
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
        $lat = null;
        $lng = null;
        if ($request->file('ad_file')) {
            $imgSrcName = $this->adService->storeAdImage($request->file('ad_file'));
        }
        if ($request->latitude && $request->longitude) {
            $lat = $request->latitude;
            $lng = $request->longitude;
        }
        $adData = $request->getPayload();
        $adId = $this->adService->createAd(array_merge($adData, [
            'img_src' => $imgSrcName,
            'latitude' => $lat,
            'longitude' => $lng,
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
    public function show(GetAdRequest $request, Ad $ad)
    {
        return view('ads/show', ['ad' => $ad]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ad $ad
     * @return Renderable
     */
    public function edit(Ad $ad): Renderable
    {
        $counties = CountryService::getAllCountry();
        return view('ads.edit', [
            'ad' => $ad,
            'countries' => $counties,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Ad $ad
     * @param UpdateAdRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Ad $ad, UpdateAdRequest $request)
    {
        $adId = $ad->id;
        $imgSrcName = null;
        $lat = null;
        $lng = null;
        if ($request->file('ad_file')) {
            $imgSrcName = $this->adService->storeAdImage($request->file('ad_file'));
        }
        if ($request->latitude && $request->longitude) {
            $lat = $request->latitude;
            $lng = $request->longitude;
        }
        $adData = $request->getPayload();
        $this->adService->updateAd(array_merge($adData, [
            'img_src' => $imgSrcName,
            'latitude' => $lat,
            'longitude' => $lng,
        ]), $ad);
        return redirect(route('ads.show', $adId));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
