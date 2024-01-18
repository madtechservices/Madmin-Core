<?php

namespace Madtechservices\MadminCore\app\Models;

use Carbon\Carbon;
use Madtechservices\MadminCore\app\Http\Controllers\FilesController;
use Madtechservices\MadminCore\app\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Backpack\CRUD\app\Models\Traits\CrudTrait;


/**
 * Class File
 *
 * @property int $id
 * @property string $uuid
 * @property int $partner_id
 * @property Partner $partner
 * @property string $original_name
 * @property string $mime_type
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class File extends Model
{
    use Uuid;
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'files';

    protected $fillable = [
        'uuid',
        'original_name',
        'mime_type',
        'path',
    ];
    protected $appends = [
        'url'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($file) {
            FilesController::deleteFile($file);
        });
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    public function getUrl()
    {
        if (!$this) {
            return "";
        }
        
        return route('madmin-core.file', $this);
    }

    public function getThumbnailUrl()
    {
        if (!$this) {
            return "";
        }
        
        return route('madmin-core.thumbnail', $this);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getUrl(),
        )->shouldCache();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
