<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Api\SubscriptionService;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

/**
 * Class UnsubscribeController
 * @package App\Http\Controllers\Api
 */
class UnsubscribeController extends Controller
{

    /**
     * @param Request $request
     * @param User $user
     * @return Renderable
     * @throws Exception
     */
    public function unsubscribe(Request $request, User $user): Renderable
    {
        SubscriptionService::unsubscribe($user);
        return view('api.unsubscribe');
    }
}
