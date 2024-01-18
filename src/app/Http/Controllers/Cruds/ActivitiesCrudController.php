<?php

namespace Madtechservices\MadminCore\app\Http\Controllers\Cruds;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Library\Widget;
use Madtechservices\MadminCore\app\Models\Activity;
use Madtechservices\MadminCore\app\Models\User;

class ActivitiesCrudController extends CrudController
{
    use ShowOperation;
    use ListOperation;

    public function setup()
    {
        crud_permission($this->crud, 'activity-list');
        $this->crud->setRoute(backpack_url('activity'));
        $this->crud->setEntityNameStrings(__('madmin-core::activities.activity'), __('madmin-core::activities.activities'));
        $this->crud->setModel(Activity::class);

        $system_error_count = Activity::query()->whereDate('created_at', \Carbon\Carbon::today())->where('log_name', 'system')->count();
        if ($system_error_count) {
            Widget::add([
                'type' => 'alert',
                'class' => 'alert alert-danger mb-2',
                'heading' => '',
                'content' => __('madmin-core::activities.activity_system_count_heading', ['count' => $system_error_count]),
            ]);
        }
    }

    protected function setupListOperation()
    {
        $this->crud->setColumns([
            [
                'name' => 'log_name',
                'label' => __('madmin-core::activities.log_name'),
                'type' => 'custom_html',
                'value' => function ($entry) {
                    if ($entry->log_name === 'system') {
                        return '<strong class="text-danger"><i class="las la-exclamation-triangle fa-fw"></i> '.$entry->log_name ?? ''.'</strong>';
                    }

                    return $entry->log_name ?? '';
                },
            ],
            [
                'name' => 'description',
                'label' => __('madmin-core::activities.description'),
                'type' => 'text',
                'limit' => 50,
            ],
            [
                'name' => 'created_at',
                'label' => __('madmin-core::activities.created_at'),
                'type' => 'datetime',
            ],
            [
                'name' => 'causer',
                'label' => __('madmin-core::activities.causer'),
                'type' => 'custom_html',
                'value' => function ($entry) {
                    if ($entry->causer === null) {
                        return '';
                    }

                    return '<a href="'.backpack_url('user/'.$entry->causer->id.'/show').'">'.$entry->causer->name.'</a>';
                },
            ],
            [
                'name' => 'subject_type',
                'limit' => 99999,
                'label' => __('madmin-core::activities.subject_type'),
                'type' => 'text',
            ],
            [
                'name' => 'subject_id',
                'label' => __('madmin-core::activities.subject_id'),
                'type' => 'text',
            ],
        ]);

        //region Filters
        $this->crud->addFilter([
            'name' => 'log_name',
            'type' => 'text',
            'label' => __('madmin-core::activities.log_name'),
        ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'log_name', 'like', '%'.$value.'%');
            });

        $this->crud->addFilter([
            'name' => 'created_at',
            'type' => 'date_range',
            'label' => __('madmin-core::activities.created_at'),
        ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                $this->crud->addClause('where', 'created_at', '<=', $dates->to.' 23:59:59');
            });

        $this->crud->addFilter([
            'name' => 'causer',
            'type' => 'select2_multiple',
            'label' => __('madmin-core::activities.causer'),
        ],
            function () {
                return User::query()->get()->keyBy('id')->pluck('name', 'id')->toArray();
            },
            function ($values) {
                $this->crud->addClause('whereIn', 'causer_type', ['App\Models\User', 'Madtechservices\MadminCore\app\Models\User']);
                $this->crud->addClause('whereIn', 'causer_id', json_decode($values));
            });
            

        $this->crud->addFilter([
            'name' => 'description',
            'type' => 'text',
            'label' => __('madmin-core::activities.description'),
        ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'description', 'like', '%'.$value.'%');
            });

        $this->crud->addFilter([
            'name' => 'subject_type',
            'type' => 'text',
            'label' => __('madmin-core::activities.subject_type'),
        ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'subject_type', 'like', '%'.$value.'%');
            });
        //endregion
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->setColumns([
            [
                'name' => 'created_at',
                'label' => __('madmin-core::activities.created_at'),
                'type' => 'datetime',
            ],
            [
                'name' => 'log_name',
                'label' => __('madmin-core::activities.log_name'),
                'limit' => 99999,
                'type' => 'custom_html',
                'value' => function ($entry) {
                    if ($entry->log_name === 'system') {
                        return '<strong class="text-danger">'.$entry->log_name ?? ''.'</strong>';
                    }

                    return $entry->log_name ?? '';
                },
            ],
            [
                'name' => 'description',
                'label' => __('madmin-core::activities.description'),
                'type' => 'text',
                'limit' => 99999,
            ],
            [
                'name' => 'subject',
                'label' => __('madmin-core::activities.subject'),
                'type' => 'custom_html',
                'value' => function ($entry) {
                    if ($entry->subject === null) {
                        return '';
                    }

                    return '<a href="'.backpack_url($entry->subject->getTable().'/'.$entry->subject->id.'/show').'">'.$entry->subject->name.'</a>';
                },
            ],
            [
                'name' => 'causer',
                'label' => __('madmin-core::activities.causer'),
                'type' => 'custom_html',
                'value' => function ($entry) {
                    if ($entry->causer === null) {
                        return '';
                    }

                    return '<a href="'.backpack_url('user/'.$entry->causer->id.'/show').'">'.$entry->causer->name.'</a>';
                },
            ],
            [
                'name' => 'properties',
                'label' => __('madmin-core::activities.properties'),
                'type' => 'view',
                'view' => 'madmin-core::columns.json',
            ],
        ]);
    }
}
