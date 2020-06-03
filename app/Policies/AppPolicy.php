<?php

namespace App\Policies;

use App\TestVersion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function access(User $user, $model)
    {
        return $user->id === $model->user_id;
    }

    public function accessToTestVersion(User $user, TestVersion $testVersion)
    {
        return $user->id === $testVersion->test['user_id'];
    }
}
