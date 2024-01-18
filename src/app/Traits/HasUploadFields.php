<?php

namespace Madtechservices\MadminCore\app\Traits;

use Madtechservices\MadminCore\app\Http\Controllers\FilesController;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Methods for storing uploaded files (used in CRUD).
|--------------------------------------------------------------------------
*/
trait HasUploadFields
{
    /**
     * Handle file upload and DB storage for a file:
     * - on CREATE
     *     - stores the file at the destination path
     *     - generates a name
     *     - stores the full path in the DB;
     * - on UPDATE
     *     - if the value is null, deletes the file and sets null in the DB
     *     - if the value is different, stores the different file and updates DB value.
     *
     * @param  string  $value  Value for that column sent from the input.
     * @param  string  $attribute_name  Model attribute name (and column in the db).
     * @param  string  $disk  Filesystem disk used to store files.
     * @param  string  $destination_path  Path in disk where to store the files.
     */
    public function uploadFileTo($value, $attribute_name, $destination_path)
    {
        // if a new file is uploaded, delete the file from the disk
        if (request()->hasFile($attribute_name) && $this->{$attribute_name} && $this->{$attribute_name} != null) {
            FilesController::deleteFile($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if the file input is empty, delete the file from the disk
        if (is_null($value) && $this->{$attribute_name} != null) {
            FilesController::deleteFile($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        if (request()->hasFile($attribute_name) && request()->file($attribute_name)->isValid()) {
            // 1. Generate a new file name
            $file = request()->file($attribute_name);

            // 2. Move the new file to the correct path
            $file_in_db = FilesController::postFile($file, $destination_path);

            // 3. Save the complete path to the database
            $this->attributes[$attribute_name] = $file_in_db->path;
        }

        if (Str::startsWith($value, 'data:image')) {
            $file_in_db = FilesController::postFileBase64($value, $destination_path);

            // FilesController::deleteFile($this->{$attribute_name});

            $this->attributes[$attribute_name] = $file_in_db->path;
        }
    }
}
