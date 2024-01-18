<?php

use Madtechservices\MadminCore\app\Utils\Sidebar\SidebarMenuItem;


return [
    'sidebar_menu' => [
        new SidebarMenuItem(
            '/admin/dashboard',
            'backpack::base.dashboard',
            'las la-home'
        ) ,
    ],

    // Ha azt szeretnénk, hogy legyen "Egy kattintásos bejelentkezés"
    'magic_link_login' => env('CORE_SHOW_MAGIC_LINK', false),

    // Ha a login screenen más logo-t akarunk megjeleníteni
    'login_logo' => env('CORE_SHOW_LOGIN_LOGO_URL', null),

    // "Account" választó megjelenítése (globális)
    'show_account_selector' => env('CORE_SHOW_ACCOUNT_SELECTOR', true),

    // Ha projekt szintent szeretnéd az error kezelést akkor ezt állítsd false-ra
    'project_uses_core_error_handling' => env('CORE_PROJECT_USES_CORE_ERROR_HANDLING', true),
    
];
