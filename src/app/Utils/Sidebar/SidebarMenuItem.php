<?php

namespace Madtechservices\MadminCore\app\Utils\Sidebar;

class SidebarMenuItem
{
    protected $url = '';

    protected $title = '';

    protected $icon = '';

    protected $permission = null;

    public function __construct($url, $title, $icon = '', $permission = null)
    {
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
        $this->permission = $permission;
    }

    public function render()
    {
        return view('madmin-core::sidebar.item', [
            'url' => $this->url,
            'title' => $this->title,
            'icon' => $this->icon,
            'permission' => $this->permission,
        ]);
    }

    public static function __set_state($an_array)
    {
        $obj = new SidebarMenuItem(
            $an_array['url'],
            $an_array['title'],
            $an_array['icon'] ?? '',
            $an_array['permission'] ?? null
        );

        return $obj;
    }
}
