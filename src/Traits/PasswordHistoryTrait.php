<?php

namespace LucaTerribili\LaravelPasswordHistoryValidation\Traits;

use LucaTerribili\LaravelPasswordHistoryValidation\Models\PasswordHistory;

trait PasswordHistoryTrait
{
    /**
     * @return mixed
     */
    public function passwordHistory()
    {
        return $this->hasMany(PasswordHistory::class)
            ->latest();
    }

    /**
     * @return void
     */
    public function deletePasswordHistory()
    {
        $keep = config('password-history.keep');
        $ids = $this->passwordHistory()
            ->pluck('id')
            ->sort()
            ->reverse();

        if ($ids->count() < $keep) {
            return;
        }

        $delete = $ids->splice($keep);

        $this->passwordHistory()
            ->whereIn('id', $delete)
            ->delete();
    }
}
