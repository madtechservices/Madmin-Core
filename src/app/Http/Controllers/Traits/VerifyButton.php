<?php

namespace Madtechservices\MadminCore\app\Http\Controllers\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait VerifyButton
{
    public function setup()
    {
        CRUD::addButton('top', 'create', 'view', 'crud::buttons.create');
    }
    
}
