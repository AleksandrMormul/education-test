<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ToggleFavoriteRequest;
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
     * @param ToggleFavoriteRequest $request
     * @param Ad $ad
     * @return JsonResponse
     */
    public function toggleFavorite(ToggleFavoriteRequest $request, Ad $ad): JsonResponse
    {
        $data = FavoriteService::toggleFavorite($ad, $request->user());
        return  response()->json($data);
    }
}
