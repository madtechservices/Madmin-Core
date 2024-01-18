<?php

namespace Madtechservices\MadminCore\app\Utils\Tab;

class TabItem
{
    protected $url = '';

    protected $title = '';

    protected $icon = '';

    protected $permission = null;

    protected $disabled = false;

    protected $showOnList = false;

    protected $showOnEdit = false;

    protected $showOnCreate = false;

    protected $showOnShow = false;

    public function __construct(
        $url,
        $title,
        $icon = '',
        $permission = null,
        $disabled = false,
        $showOnList = false,
        $showOnEdit = false,
        $showOnCreate = false,
        $showOnShow = false
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
        $this->permission = $permission;
        $this->disabled = $disabled;
        $this->showOnList = $showOnList;
        $this->showOnEdit = $showOnEdit;
        $this->showOnCreate = $showOnCreate;
        $this->showOnShow = $showOnShow;
    }

    public function render($type)
    {
        switch ($type) {
            case 'list':
                if (!$this->showOnList) return "";
                break;
            case 'edit':
                if (!$this->showOnEdit) return "";
                break;
            case 'create':
                if (!$this->showOnCreate) return "";
                break;
            case 'show':
                if (!$this->showOnShow) return "";
                break;
        }
        
        return view('madmin-core::crud.tabs.item', [
            'url' => $this->url,
            'title' => $this->title,
            'icon' => $this->icon,
            'permission' => $this->permission,
            'disabled' => $this->disabled,
        ]);
    }

    public function isRenderable($type)
    {
        switch ($type) {
            case 'list':
                if ($this->showOnList) return true;
                break;
            case 'edit':
                if ($this->showOnEdit) return true;
                break;
            case 'create':
                if ($this->showOnCreate) return true;
                break;
            case 'show':
                if ($this->showOnShow) return true;
                break;
        }

        return false;
    }
}
