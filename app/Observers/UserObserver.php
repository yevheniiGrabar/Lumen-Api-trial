<?php

namespace App\Observers;

use App\Models\Action;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 *
 */
trait UserObserver
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            Action::create([
                'model' => User::class,
                'actions' => self::class . '@created'
            ]);
        });

        static::updated(function ($user) {
            Action::create([
                'model' => User::class,
                'actions' => self::class . '@updated'
            ]);
        });

        static::deleted(function ($user) {
            Action::create([
                'model' => User::class,
                'actions' => self::class . '@deleted'
            ]);
        });
    }
}
