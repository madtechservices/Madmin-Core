<?php

namespace Madtechservices\MadminCore;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Different\LaravelBackpackMadminExtension\Skeleton\SkeletonClass
 */
class MadminCoreFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'madmin-core';
    }
}
