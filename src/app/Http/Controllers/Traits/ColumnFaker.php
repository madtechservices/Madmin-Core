<?php

namespace Madtechservices\MadminCore\app\Http\Controllers\Traits;

trait ColumnFaker
{
    /**
     * adds {$column}_id with value to the grid/request before storing data
     *
     * @param  string  $column The name of the foreign key column, without the "_id" suffix
     * @param  null  $value
     */
    protected function addColumnIdToRequest(string $column, $value = null, $suffix = '_id'): void
    {
        if ($value === null && isset($this->{$column.$suffix})) {
            $value = $this->{$column.$suffix};
        } elseif ($value === '') {
            $value = null;
        } elseif ($value === null) {
            return;
        }
        $this->crud->addField(['name' => $column.$suffix, 'type' => 'hidden', 'default' => $value]);
        $this->crud->getRequest()->request->add([$column.$suffix => $value]);
    }
    
}
