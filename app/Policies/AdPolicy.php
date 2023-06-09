<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use App\Services\AdService;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class AdPolicy
 * @package App\Policies
 */
class AdPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param Ad $ad
     * @return bool
     */
    public function view(?User $user, Ad $ad): bool
    {
        return !($ad->status_paid === AdService::PAID || $ad->status_paid === AdService::RESERVATION);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        if ($user->isAdmin() || $user->isAuthor()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  Ad $ad
     * @return bool
     */
    public function update(User $user, Ad $ad): bool
    {
        if ($ad->status_paid === AdService::PAID || $ad->status_paid === AdService::RESERVATION) {
            return false;
        }
        return $user->id === $ad->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Ad $ad
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Ad $ad): bool
    {
        $isAuthorAd = $user->id === $ad->user_id;
        if ($ad->status_paid === AdService::PAID || $ad->status_paid === AdService::RESERVATION) {
            return false;
        }
        if ($user->isAdmin() || $isAuthorAd) {
            return true;
        }
        return false;
    }
}
