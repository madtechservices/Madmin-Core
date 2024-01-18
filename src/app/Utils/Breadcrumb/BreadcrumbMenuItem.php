<?php

namespace Madtechservices\MadminCore\app\Utils\Breadcrumb;

class BreadcrumbMenuItem
{
    protected $url = '';

    protected $title = '';

    protected $icon = '';

    protected $permission = null;

    protected $disabled = false;

    public function __construct($url, $title, $icon = '', $permission = null, $disabled = false)
    {
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
        $this->permission = $permission;
        $this->disabled = $disabled;
    }

    public function render()
    {
        return view('madmin-core::breadcrumb.item', [
            'url' => $this->url,
            'title' => $this->title,
            'icon' => $this->icon,
            'permission' => $this->permission,
            'disabled' => $this->disabled,
        ]);
    }
}
