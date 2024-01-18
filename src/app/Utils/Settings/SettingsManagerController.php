<?php

namespace Madtechservices\MadminCore\app\Utils\Settings;

use Madtechservices\MadminCore\app\Http\Controllers\FilesController;
use Madtechservices\MadminCore\app\Models\File;
use Madtechservices\MadminCore\app\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;


class SettingsManagerController
{
    /**
     * Retrieve the settings from DB.
     */
    public static function getDatabaseSettings(): Collection
    {
        return Setting::all();
    }

    /**
     * Deletes unused settings from database. This uses the seeder as the only source of truth
     *
     * @return void
     */
    public static function cleanUpDatabaseSettings($seededSettings)
    {
        $settings_in_db = Setting::query()->get()->toArray();
        if (! empty($settings_in_db) && ! empty($seededSettings)) {
            $settings_in_db = Arr::pluck($settings_in_db, 'name');
            if (! empty($diff = array_diff($settings_in_db, $seededSettings))) {
                foreach ($diff as $settingToDelete) {
                    if (in_array($settingToDelete, $settings_in_db)) {
                        Setting::query()->where('name', $settingToDelete)->first()->delete();
                    }
                }
            }
        }
    }

    /**
     * Returns the setting value.
     *
     * @param  string  $setting
     * @return mixed
     */
    public static function get($setting): mixed
    {
        $name = is_string($setting) ? $setting : (is_array($setting) ? $setting['name'] : abort(500, 'Could not parse setting.'));
        $setting = Setting::query()->where('name', $name)->first();
        if (isset($setting) && ! empty($setting)) {
            return $setting?->value ?? '';
        }

        return '';
    }

    /**
     * Updates the setting value.
     *
     * @param  string  $setting
     * @return mixed
     */
    public static function set($setting, $value): mixed
    {
        $name = is_string($setting) ? $setting : (is_array($setting) ? $setting['name'] : abort(500, 'Could not parse setting.'));
        $setting = Setting::query()->where('name', $name)->first();
        if (isset($setting) && ! empty($setting)) {
            $setting->value = $value;
            $setting->save();
        }
        return $setting;
    }

    public static function settingExists($setting): bool
    {
        $name = is_string($setting) ? $setting : (is_array($setting) ? $setting['name'] : abort(500, 'Could not parse setting.'));

        return Setting::query()->where('name', $name)->count() > 0;
    }

    public static function create($settings)
    {
        foreach ($settings as $setting) {
            $dbSetting = null;
            $setting['type'] ?? abort(500, 'Setting need a type.');
            $setting['name'] ?? abort(500, 'Setting need a name.');
            $setting['tab'] = $setting['tab'] ?? null;
            $setting['group'] = $setting['group'] ?? null;
            $setting['value'] = $setting['value'] ?? null;
            $setting['label'] = $setting['label'] ?? $setting['name'];

            $settingOptions = Arr::except($setting, ['type', 'name', 'label', 'tab', 'group', 'value', 'id']);

            $dbSetting = Setting::query()->where('name', $setting['name'])->first();

            if (! isset($dbSetting) && is_null($dbSetting)) {
                $dbSetting = Setting::query()->create([
                    'name' => $setting['name'],
                    'type' => $setting['type'],
                    'label' => $setting['label'],
                    'tab' => $setting['tab'] ?? null,
                    'group' => $setting['group'] ?? null,
                    'value' => $setting['value'] ?? null,
                ]);
            }

            $dbSetting->options = $settingOptions;
            $dbSetting->save();
        }
    }

    public static function delete($settingName)
    {
        $dbSetting = Setting::query()->where('name', $settingName)->first();

        if (isset($dbSetting) && ! is_null($dbSetting)) {
            $dbSetting->delete();
        }
    }

    public static function getFieldValidations($settings): array
    {
        $validations = [];
        foreach (Setting::query()->whereIn('name', array_keys($settings))->get() as $setting) {
            $validations[$setting['name']] = $setting['options']['validation'] ?? null;
        }

        return array_filter($validations);
    }

    public static function saveSettingsValues($settings): bool
    {
        $settingsInDb = Setting::query()->get();
        foreach ($settings as $settingName => $settingValue) {
            $setting = $settingsInDb->where('name', $settingName)->first();
            if(!$setting)
            {
                if(str_starts_with($settingName, 'upload_'))
                {
                    $setting = $settingsInDb->where('name', explode('upload_', $settingName)[1])->first();
                }elseif(str_starts_with($settingName, 'remove_'))
                {
                    $setting = $settingsInDb->where('name', explode('remove_', $settingName)[1])->first();
                }
            }
            if (! is_null($setting)) {
                switch ($setting->type) {
//                    case 'image': { TODO FIXME
//                        $settingValue = $this->saveImageToDisk($settingValue, $settingName);
//                    }
                    case 'file':
                        if(str_starts_with($settingName, 'upload_'))
                        {
                            $column = $key = explode('upload_', $settingName)[1];
                        }elseif(str_starts_with($settingName, 'remove_'))
                        {
                            $column = $key = explode('remove_', $settingName)[1];
                        }else{
                            $column = $key = $settingName;
                        }

                        if ($column === null) {
                            throw new \ErrorException("A `name` mező megadása kötelező fájl / kép feltöltés mező esetén! Ez határozza meg, hogy hova szúrja be a App\Models\File id-t.");
                        }

                        $upload_key = 'upload_' . $key;
                        $remove_key = 'remove_' . $key;

                        $pending_upload = request()->file($upload_key) ?? null;
                        $pending_remove = request()->get($remove_key) ?? null;

                        if ($pending_remove) {
                            $file = File::query()->find($pending_remove);
                            if ($file) {
                                $file->delete();
                            }

                            if (!$pending_upload) {
                                // Ha nincs új feltöltés, csak simán kitörlöm és mentek, akkor el kell menteni az adott sor file mezőjét üresen!
                                $setting->update(['value' => null]);
                            }
                        }

                        if ($pending_upload && request()->hasFile($upload_key)) {
                            $storage_dir = 'settings' . '/' . date('Y') . '/' . date('m') . '/' . $column;
                            $file = FilesController::postFile($pending_upload, $storage_dir);
                            $setting->update(['value' => $file->id]);
                        }
                        break;
                    default:
                        $setting->update(['value' => $settingValue]);
                }
            }
        }

        return true;
    }

    public static function getFieldsForEditor(): array
    {
        $settings = Setting::query()->get();
        foreach ($settings as &$setting) {
            foreach ($setting->options as $key => $option) {
                $setting->{$key} = $option;
            }
            unset($setting->options);
        }

        return $settings->keyBy('name')->toArray();
    }

    public static function update(array $setting): int
    {
        return Setting::query()->where('name', $setting['name'])->update(Arr::except($setting, ['name']));
    }

    public static function saveImageToDisk($image, $settingName)
    {
        // TODO: Fixme
        /*$disk = config('bpsettings.image_save_disk');
        $prefix = config('bpsettings.image_save_disk');

        $setting = Setting::where('name', $settingName)->first();

        if ($image === null) {
            // delete the image from disk
            if(Storage::disk($disk)->has($setting->value))
            {
                Storage::disk($disk)->delete($setting->value);
            }

            // set null in the database column
            return null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($image, 'data:image'))
        {
            // 0. Make the image
            $imageCreated = \Image::make($image);

            // 1. Generate a filename.
            $filename = md5($image.time()).'.jpg';
            // 2. Store the image on disk.
            if(Storage::disk($disk)->has($setting->value))
            {
                Storage::disk($disk)->delete($setting->value);
            }

            Storage::disk($disk)->put($prefix.$filename, $imageCreated->stream());
            // 3. Save the path to the database

            return $prefix.$filename;
        }

        return $setting->value;*/
    }
}
