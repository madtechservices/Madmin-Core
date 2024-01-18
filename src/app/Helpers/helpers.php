<?php


if (! function_exists('user_can')) {
    /**
     * Az átadott permission-höz van-e joga a felhasználónak.
     *
     * @param  string  $permissions
     */
    function user_can(string $permission)
    {
        return backpack_user()->hasRole('super-admin') || backpack_user()->can($permission);
    }
}

if (! function_exists('user_can_any')) {
    /**
     * Az átadott permission-ök közül van-e joga a felhasználónak legalább az egyikhez.
     *
     * @param  array  $permissions
     */
    function user_can_any(array $permissions)
    {
        if (backpack_user()->hasRole('super-admin')) {
            return true;
        }

        foreach ($permissions as $permission) {
            if (backpack_user()->can($permission)) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('crud_permission')) {
    /**
     * Letiltja az összes CRUD műveletet ha nincs ez a permission a felhasználónak.
     *
     * @param  Backpack\CRUD\app\Library\CrudPanel\CrudPanel  $crud
     * @param  string  $name
     */
    function crud_permission($crud, $name)
    {
        if (! user_can($name)) {
            $crud->denyAccess([
                'list',
                'show',
                'create',
                'update',
                'delete',
            ]);
        }
    }
}

if (! function_exists('crud_permissions')) {
    /**
     * Letiltja az egyes CRUD műveletet ha nincs a $name-el kezdődő permission. Például user estén a következő permission-ök: user-list, user-show stb.
     *
     * @param  Backpack\CRUD\app\Library\CrudPanel\CrudPanel  $crud
     * @param  string  $name
     */
    function crud_permissions($crud, $name)
    {
        $permissions = [
            'list',
            'show',
            'create',
            'update',
            'delete',
        ];
        foreach ($permissions as $permission) {
            if (! user_can($name.'-'.$permission)) {
                $crud->denyAccess($permission);
            }
        }
    }
}

if (! function_exists('store_system_logs')) {
    /**
     * Tárolja a rendszer szintű hibákat.
     *
     * Használati utasítás:
     * Nyisd meg az alábbi fájlt: app\Exceptions\Handler.php
     * public function register()
     * {
     *   $this->reportable(function (Throwable $e) {
     *       if ($this->shouldReport($e)) {
     *           store_system_logs($e);
     *       }
     *   });
     * }
     *
     * @param  Throwable  $e
     */
    function store_system_logs($e)
    {
        activity()->byAnonymous()->useLog('system')->withProperties($e->getTrace())->log($e->getMessage());
    }
}


if (! function_exists('rendered_tab_count')) {
    function rendered_tab_count($tabs, $type)
    {
        $count = 0;
        foreach ($tabs as $tab) {
            if ($tab->isRenderable($type)) {
                $count++;
            }
        }
        return $count;
    }
}
