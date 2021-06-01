<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubscriptionRequest;
use App\Models\User;
use App\Services\SubscriptionService;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;

/**
 * Class SubscriptionController
 * @package App\Http\Controllers\Api
 */
class SubscriptionController extends Controller
{

    /**
     * @param SubscriptionRequest $request
     * @return JsonResponse
     */
    public function subscribe(SubscriptionRequest $request): JsonResponse
    {
        if (auth()->user()) {
            try {
                $response = SubscriptionService::subscribe($request->user());

                //back()->with('success', $response['message']);
                return response()->json($response);
            } catch (Exception $exception) {
                back()->with('error', $exception->getMessage());
            }
        }
    }

    /**
     * @param SubscriptionRequest $request
     * @param User $user
     * @return Renderable
     * @throws Exception
     */
    public function unsubscribe(SubscriptionRequest $request, User $user): Renderable
    {
        SubscriptionService::unsubscribe($user);
        return view('api.unsubscribe');
    }
}
