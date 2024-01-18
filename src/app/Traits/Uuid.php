<?php

namespace Madtechservices\MadminCore\app\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}
