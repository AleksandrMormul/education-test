<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Services\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class FavoriteController
 * @package App\Http\Controllers\Api
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
        if (auth()->user()) {
            $data = FavoriteService::toggleFavorite($ad, $request->user());
            return  response()->json($data);
        }
    }
}
