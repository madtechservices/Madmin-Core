<?php

namespace Madtechservices\MadminCore\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;


/**
 * Class Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $readable_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Permission extends OriginalPermission
{
    use CrudTrait;

    protected $fillable = [
        'name',
        'guard_name',
        'readable_name',
        'group',
    ];

    public $timestamps = true;
}
