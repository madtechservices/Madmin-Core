<?php

namespace Madtechservices\MadminCore\app\Http\Controllers\Cruds;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Madtechservices\MadminCore\app\Http\Controllers\Traits\FileUpload;
use Illuminate\Support\Facades\Route;
use Madtechservices\MadminCore\app\Http\Middlewares\AccountCheckMiddleware;

class BaseCrudController extends CrudController
{
    use FileUpload;

    protected function setupConfigurationForCurrentOperation()
    {
        parent::setupConfigurationForCurrentOperation();

        $this->data['crud_account_selector'] = $this->isAccountBasedCrud();

        if (isset($this->data['tabs']) && count($this->data['tabs'])) {
            $this->crud->setListView('madmin-core::crud.tabs.list');
            $this->crud->setShowView('madmin-core::crud.tabs.show');
            $this->crud->setCreateView('madmin-core::crud.tabs.create');
            $this->crud->setEditView('madmin-core::crud.tabs.edit');
        }
    }

    
    protected function addAccountIdFieldIfNeeded()
    {
        if ($this->isAccountBasedCrud()) {
            if (array_key_exists('account_id', $this->crud->getFields())) return;
            $this->crud->addField(['name' => 'account_id', 'type' => 'hidden', 'default' => session('account_id')]);
            $this->crud->getRequest()->request->add(['account_id' => session('account_id')]);
        }
    }

    protected function addUserIdField()
    {
        if (array_key_exists('user_id', $this->crud->getFields())) return;
        $this->crud->addField(['name' => 'user_id', 'type' => 'hidden', 'default' => backpack_user()->id]);
        $this->crud->getRequest()->request->add(['user_id' => backpack_user()->id]);
    }

    protected function store()
    {
        $this->crud->hasAccessOrFail('create');

        $this->addAccountIdFieldIfNeeded();

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        $this->handleFileUpload($this->crud->entry);

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    protected function update()
    {
        $this->crud->hasAccessOrFail('update');

        $this->addAccountIdFieldIfNeeded();

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        // update the row in the db
        $item = $this->crud->update(
            $request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request)
        );
        $this->data['entry'] = $this->crud->entry = $item;

        $this->handleFileUpload($this->crud->entry);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    protected function isAccountBasedCrud()
    {
        return in_array(AccountCheckMiddleware::class , Route::current()->gatherMiddleware());
    }

    protected function setupColumnsFieldsFromMethod(): void
    {
        $this->crud->setColumns($this->getColumns());
        $this->crud->addFields($this->getFields());
    }

    protected function setupFiltersFromMethod(): void
    {
        foreach($this->getFilters() as $filter) {
            $this->crud->addFilter($filter[0], $filter[1], $filter[2]);
        }
    }
}
