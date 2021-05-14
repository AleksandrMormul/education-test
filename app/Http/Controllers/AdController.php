<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ad\GetAdRequest;
use App\Http\Requests\Ad\StoreAdRequest;
use App\Http\Requests\Ad\UpdateAdRequest;
use App\Models\Ad;
use App\Services\AdService;
use App\Services\CountryService;
use Carbon\Carbon;
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
        $now = Carbon::now()->addDay()->toDateString();
        return view(
            'ads/index',
            [
                'ads' => $query->where('end_date', '>=', $now)->paginate(15),
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
        $adId = $this->adService->createAd($request->prepareRequest());

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
     * @return Response
     */
    public function update(Ad $ad, UpdateAdRequest $request)
    {
        $adId = $ad->id;
        $this->adService->updateAd($request->prepareRequest(), $ad);
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
