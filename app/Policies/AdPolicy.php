<?php

namespace App\Policies;

use App\Models\Ad;

/**
 * Class AdPolicy
 * @package App\Policies
 */
class AdPolicy extends ModelPolicy
{

    protected function getModelClass(): string
    {
        return Ad::class;
    }
}
