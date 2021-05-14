<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ad\StoreAdRequest;
use App\Http\Requests\Ad\GetAdRequest;
use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $query = $this->adService->getAds();
        return view(
            'ads/index',
            [
                'ads' => $query->paginate(15)
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
        $this->authorize('create', Ad::class);
        return view('ads/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(StoreAdRequest $request)
    {
        $this->authorize('store', Ad::class);
        $adId = $this->adService->createAd($request);

        return redirect(route('ads.show', $adId));
    }

    /**
     * Display the specified resource.
     *
     * @param GetAdRequest $request
     * @param  Ad  $ad
     * @return Renderable
     */
    public function show(GetAdRequest $request, Ad $ad)
    {
        return view('ads/show', ['ad' => $ad]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ad  $ad
     * @return Renderable
     */
    public function edit(Ad $ad): Renderable
    {
        $this->authorize('edit', Ad::class);
        return view('ads.edit', ['ad' => $ad]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreAdRequest $request
     * @param Ad $ad
     * @return Response
     */
    public function update(StoreAdRequest $request, Ad $ad)
    {
        $this->authorize('update', Ad::class);
        $adId = $ad->id;
        $this->adService->updateAd($request, $adId);
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
