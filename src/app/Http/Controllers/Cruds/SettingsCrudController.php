<?php

namespace Madtechservices\MadminCore\app\Http\Controllers\Cruds;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Madtechservices\MadminCore\app\Models\Setting;
use Madtechservices\MadminCore\app\Utils\Settings\SettingsManagerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setRoute(backpack_url('settings'));
        $this->crud->setModel(Setting::class);
        $this->crud->setEntityNameStrings(trans('madmin-core::settings.setting'), trans('madmin-core::settings.settings')); // TODO: Fixme
    }

    public function index()
    {
        $fields = SettingsManagerController::getFieldsForEditor();

        foreach ($fields as $field) {
            $this->crud->addField($field);
        }

        $this->data['breadcrumbs'] = [
            trans('backpack::crud.admin') => backpack_url('dashboard'),
            trans('madmin-core::settings.settings') => false,
        ];
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);

        return view('madmin-core::settings.settings', $this->data);
    }

    public function save(Request $request)
    {
        $settings = $request->except(['http_referrer', '_token']);
        $validationRules = SettingsManagerController::getFieldValidations($settings);

        Validator::make($settings, $validationRules)->validate();

        if (SettingsManagerController::saveSettingsValues($settings)) {
            return response()->json('success');
        }

        return response()->json('saving error');
    }
}
