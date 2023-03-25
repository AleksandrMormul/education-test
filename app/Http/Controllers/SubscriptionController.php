<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\SubscriptionRequest;
use App\Models\User;
use App\Services\SubscriptionService;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;

/**
 * Class SubscriptionController
 * @package App\Http\Controllers
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

            switch ($response) {
                case SubscriptionService::SUBSCRIBED:
                    return response()->json([
                        'success' => 'subscribe',
                        'message' => 'You was successfully subscribed on weekly sending emails :)',
                    ]);
                    break;
                case SubscriptionService::UNSUBSCRIBED:
                    return response()->json([
                        'success' => 'unsubscribe',
                        'message' => 'You was successfully unsubscribed on weekly sending emails :('
                    ]);
                    break;
                default:
                    throw new Exception('Something went wrong');
            }
        } catch (Exception $exception) {
            back()->with('error', $exception->getMessage());
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

        return view('emails.unsubscribe');
    }
}
