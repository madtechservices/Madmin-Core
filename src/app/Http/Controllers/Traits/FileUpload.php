<?php

namespace Madtechservices\MadminCore\app\Http\Controllers\Traits;

use Madtechservices\MadminCore\app\Http\Controllers\FilesController;
use Madtechservices\MadminCore\app\Models\File;

trait FileUpload

{
    protected function handleFileUpload($entry)
    {
        $fields = $this->crud->get('update.fields');
        if ($fields === null) {
            $fields = $this->crud->get('create.fields');
            if ($fields === null) {
                return;
            }
        }

        foreach ($fields as $key => $options) {
            switch ($options['type']) {
                case 'file':
                    $column = $options['name'] ?? null;

                    if ($column === null) {
                        throw new \ErrorException("A `name` mező megadása kötelező fájl / kép feltöltés mező esetén! Ez határozza meg, hogy hova szúrja be a App\Models\File id-t.");
                    }

                    $upload_key = 'upload_' . $key;
                    $remove_key = 'remove_' . $key;

                    $pending_upload = $this->crud->getRequest()->{$upload_key} ?? null;
                    $pending_remove = $this->crud->getRequest()->{$remove_key} ?? null;

                    if ($pending_remove) {
                        $file = File::query()->find($pending_remove);
                        if ($file) {
                            $file->delete();
                        }

                        if (!$pending_upload) {
                            // Ha nincs új feltöltés, csak simán kitörlöm és mentek, akkor el kell menteni az adott sor file mezőjét üresen!
                            $entry->{$column . '_id'} = null;
                            $entry->save();
                        }
                    }

                    if ($pending_upload && $this->crud->getRequest()->hasFile($upload_key)) {
                        $storage_dir = $this->crud->model->getTable() . '/' . date('Y') . '/' . date('m') . '/' . $column;
                        $file = FilesController::postFile($pending_upload, $storage_dir);
                        $entry->{$column . '_id'} = $file->id;
                        $entry->save();
                    }

                    break;
                case 'file_multiple':
                    $column = $options['name'] ?? null;

                    if ($column === null) {
                        throw new \ErrorException("A `name` mező megadása kötelező fájl / kép feltöltés mező esetén! Ez határozza meg, hogy hova szúrja be a App\Models\File id-t.");
                    }

                    $upload_key = 'upload_' . $key;
                    $remove_key = 'remove_' . $key;

                    $pending_uploads = $this->crud->getRequest()->{$upload_key} ?? [];
                    $pending_removes = $this->crud->getRequest()->{$remove_key} ?? [];

                    if (count($pending_removes) > 0) {
                        foreach ($pending_removes as $file_id) {
                            $file = File::query()->find($file_id);
                            if ($file) {
                                $file->delete();
                            }
                        }
                    }

                    if (count($pending_uploads) > 0) {
                        $file_ids = [];
                        foreach ($pending_uploads as $pending_upload) {
                            if ($pending_upload && $pending_upload instanceof \Illuminate\Http\UploadedFile) {
                                $storage_dir = $this->crud->model->getTable() . '/' . date('Y') . '/' . date('m') . '/' . $column;
                                $file = FilesController::postFile($pending_upload, $storage_dir);
                                $file_ids[] = $file->id;
                            }
                        }

                        if (count($file_ids)) {
                            $entry->{$column}()->syncWithoutDetaching($file_ids);
                        }
                    }
                    break;
                    /*case "base64_image":
                case "image":
                    $column = $options["column"]??null;

                    if ($column === null) {
                        throw new \ErrorException("A `column` mező megadása kötelező fájl / kép feltöltés mező esetén! Ez határozza meg, hogy hova szúrja be a App\Models\File id-t.");
                    }

                    $storage_dir = $this->crud->model->getTable() . "/" . date("Y") . "/" . date("m") . "/" . $column;
                    $value = $this->crud->getRequest()->{$key}??null;

                    if ($value !== null) {
                        if ($this->isBase64Image($value)) {
                            // Ha a base64 képet töltenek fel.
                            $file = FilesController::postFileBase64($value, $storage_dir);
                            $this->addHiddenFileColumn($column, $file->id);
                        } elseif ($this->crud->getRequest()->hasFile($key)) {
                            // Ha sima fájlt töltenek fel.
                            $file = FilesController::postFile($value, $storage_dir);
                            $this->addHiddenFileColumn($column, $file->id);
                        }
                    }
                    else {
                        $model_primary_id = $this->crud->getRequest()->{$this->crud->model->getKeyName()};
                        if ($model_primary_id) {
                            $row = $this->crud->model->find($model_primary_id);
                            if ($row) {
                                $file_id = $row->{$column};
                                if ($file_id) {
                                    $file = File::query()->findOrFail($file_id);
                                    if ($file) {
                                        $file->delete();
                                    }
                                }
                            }
                        }
                        $this->addHiddenFileColumn($column, null);
                    }
                    $this->crud->getRequest()->request->remove($key);
                    break;*/
            }
        }
    }

    /**
     * @param  string  $value
     * @return bool
     */
    private function isBase64Image($value)
    {
        $explode = explode(',', $value);
        $allow = ['png', 'jpg', 'jpeg', 'svg', 'gif'];
        $format = str_replace(
            [
                'data:image/',
                ';',
                'base64',
            ],
            [
                '', '', '',
            ],
            $explode[0]
        );
        if (!in_array($format, $allow)) {
            return false;
        }
        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
            return false;
        }

        return true;
    }

    private function addHiddenFileColumn($column, $value)
    {
        $this->crud->addField(['name' => $column, 'type' => 'hidden', 'default' => $value]);
        $this->crud->getRequest()->request->add([$column => $value]);
    }
}
