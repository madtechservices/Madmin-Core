<?php

namespace Madtechservices\MadminCore\app\Utils\Sidebar;

class SidebarMenuLabel
{
    protected $title = '';

    protected $permissions = null;

    public function __construct($title, $permissions = null)
    {
        $this->title = $title;
        $this->permissions = $permissions;
    }

    public function render()
    {
        return view('madmin-core::sidebar.label', [
            'title' => $this->title,
            'permissions' => $this->permissions,
        ]);
    }

    public static function __set_state($an_array)
    {
        $obj = new SidebarMenuLabel(
            $an_array['title'],
            $an_array['permissions'] ?? null
        );

        return $obj;
    }
}
