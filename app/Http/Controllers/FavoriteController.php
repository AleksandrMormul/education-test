<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Services\FavoriteService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class FavoriteController
 * @package App\Http\Controllers
 */
class FavoriteController extends Controller
{
    /**
     * @param Request $request
     * @param Ad $ad
     * @return JsonResponse
     */
    public function toggleFavorite(Request $request, Ad $ad): JsonResponse
    {
        $data = FavoriteService::toggleFavorite($ad);
        return  response()->json($data);
    }

    /**
     * @return Application|View
     * @throws BindingResolutionException
     */
    public function showFavorite()
    {
        $favorites = FavoriteService::getFavoriteAds();

        return view('ads.favorite', [
            'favoritesAds' => $favorites,
        ]);
    }
}
