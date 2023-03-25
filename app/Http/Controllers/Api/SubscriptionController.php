<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubscriptionRequest;
use App\Models\User;
use App\Services\SubscriptionService;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
        try {
            $response = SubscriptionService::subscribe($request->user());

            if (
                array_key_exists(SubscriptionService::SUBSCRIBED, $response) &&
                $response[SubscriptionService::SUBSCRIBED]
            ) {
                return response()->json([
                    'success' => 'subscribe',
                    'message' => 'You was successfully subscribed on weekly sending emails :)',
                ]);
            }

            if (
                array_key_exists(SubscriptionService::UNSUBSCRIBED, $response) &&
                $response[SubscriptionService::UNSUBSCRIBED]
            ) {
                return response()->json([
                    'success' => 'unsubscribe',
                    'message' => 'You was successfully unsubscribed on weekly sending emails :('
                ]);
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
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
