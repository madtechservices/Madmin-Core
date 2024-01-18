<?php

namespace Madtechservices\MadminCore\app\Models;


use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @property int $id
 * @property string $title
 * @property string slug
 * @property string content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Post extends Model
{
    use CrudTrait;
    use HasFactory;
    use SoftDeletes;

    //region Globális változók
    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'slug',
        'content'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $guard_name = 'web';
    //endregion


}
