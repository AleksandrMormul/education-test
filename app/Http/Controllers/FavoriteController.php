<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Services\AdService;
use App\Services\FavoriteService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $data = FavoriteService::toggleFavorite($ad, $user);
        return  response()->json($data);
    }

    /**
     * @return Application|View
     * @throws BindingResolutionException
     */
    public function index()
    {
        $user = Auth::user();
        $favorites = AdService::getFavoriteAds($user);

        return view('ads.favorite', [
            'favoritesAds' => $favorites,
        ]);
    }
}
