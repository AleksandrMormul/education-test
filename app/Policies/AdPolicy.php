<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
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
<<<<<<<<< Temporary merge branch 1
     * @param User $user
=========
     * @param User|null $user
>>>>>>>>> Temporary merge branch 2
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
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
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
        return $user->id === $ad->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Ad $ad
     * @return bool
     */
    public function delete(User $user, Ad $ad): bool
    {
        $isAuthorAd = $user->id === $ad->user_id;
        if ($user->isAdmin() || $isAuthorAd) {
            return true;
        }
        return false;
    }
}
