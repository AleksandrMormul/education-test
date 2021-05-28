<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\URL;

/**
 * Class SignedUrlService
 * @package App\Services\Api
 */
class SignedUrlService
{
    /**
     * @param User $user
     * @return string
     */
    public static function getSignedUrl(User $user): string
    {
        return URL::signedRoute('unsubscribe', ['user' => $user->id]);
    }
}
