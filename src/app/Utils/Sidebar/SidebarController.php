<?php

namespace Madtechservices\MadminCore\app\Utils\Sidebar;

class SidebarController
{
    public static function menus()
    {
        $default = [
            new SidebarMenuGroup(
                'madmin-core::sidebar.system',
                [
                    new SidebarMenuItem(route('admin.post.index'), 'madmin-core::posts.posts', 'las la-clipboard', 'post-list'),
                    new SidebarMenuItem(route('admin.user.index'), 'madmin-core::users.users', 'las la-user', 'user-list'),
                    new SidebarMenuItem(route('admin.account.index'), 'madmin-core::accounts.accounts', 'las la-users', 'account-list'),
                    new SidebarMenuItem(route('admin.role.index'), 'madmin-core::roles.roles', 'las la-id-badge', 'role-manage'),
                    new SidebarMenuItem(route('admin.activity.index'), 'madmin-core::activities.activities', 'las la-history', 'activity-list'),
                    new SidebarMenuItem(route('admin.filemanager.index'), 'madmin-core::files.files', 'las la-folder', 'file-manage'),
                    new SidebarMenuItem(route('admin.settings'), 'madmin-core::settings.settings', 'las la-sliders-h', 'setting-manage'),
                ],
                'las la-cog',
                [
                    'post-list',
                    'user-list',
                    'role-manage',
                    'activity-list',
                    'setting-manage',
                ]
            ),
        ];

        return array_merge(
            config('madmin-core.config.sidebar_menu'),
            $default,
        );
    }
}
