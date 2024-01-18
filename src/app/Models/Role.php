<?php

namespace Madtechservices\MadminCore\app\Models;


use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Models\Role as OriginalRole;
use Spatie\Activitylog\Facades\CauserResolver;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $readable_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Role extends OriginalRole
{
    use CrudTrait;
    use LogsActivity;

    protected $fillable = [
        'name',
        'guard_name',
        'readable_name',
    ];

    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        CauserResolver::setCauser(backpack_user());
        return LogOptions::defaults()->useLogName('role')->logFillable();
    }
}
