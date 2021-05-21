<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdPolicy
{
    use HandlesAuthorization;

    /**
     * @var RoleService
     */
    private $roleService;

    public function __construct(RoleService $service)
    {
        $this->roleService = $service;
    }
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
        if ($this->roleService->isAdmin() || $this->roleService->isAuthor()) {
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
