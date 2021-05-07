<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdRequest;
use App\Http\Requests\GetAdRequest;
use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @param mixed $service
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
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ads/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdRequest $request
     * @return Response
     */
    public function store(CreateAdRequest $request)
    {

        $this->adService->createAd($request);

        return redirect('ads');
    }

    /**
     * Display the specified resource.
     *
     * @param GetAdRequest $request
     * @param  Ad  $ad
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(GetAdRequest $request, Ad $ad)
    {
        return view(
            'ads/show',
            [
                'ad' => $ad,
                'user' => $ad->user]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
