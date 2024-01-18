<?php

namespace Madtechservices\MadminCore\app\Models;


use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Facades\CauserResolver;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends Model
{
    use CrudTrait;
    use LogsActivity;

    protected $table = 'settings';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'label',
        'value',
        'type',
        'tab',
        'name',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function getActivitylogOptions(): LogOptions
    {
        CauserResolver::setCauser(backpack_user());
        return LogOptions::defaults()->useLogName('setting')->logFillable();
    }
}
