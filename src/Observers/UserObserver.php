<?php

namespace LucaTerribili\LaravelPasswordHistoryValidation\Observers;

use Illuminate\Support\Arr;
use LucaTerribili\LaravelPasswordHistoryValidation\Models\PasswordHistoryRepo;

class UserObserver
{
    /**
     * @param $user
     * @return void
     */
    public function updated($user)
    {
        $configPasswordColumn = config('password-history.observe.column');
        if ($password = Arr::get($user->getChanges(), $configPasswordColumn)) {
            PasswordHistoryRepo::storeCurrentPasswordInHistory($password, $user->id);
        }
    }

    /**
     * @param $user
     * @return void
     */
    public function created($user)
    {
        $password = config('password-history.observe.column') ?? 'password';
        PasswordHistoryRepo::storeCurrentPasswordInHistory($user->{$password}, $user->id);
    }
}
