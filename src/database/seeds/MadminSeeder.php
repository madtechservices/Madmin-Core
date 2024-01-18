<?php

namespace Madtechservices\MadminCore\Database\Seeds;

use Madtechservices\MadminCore\app\Models\Account;
use Madtechservices\MadminCore\app\Models\Permission;
use Madtechservices\MadminCore\app\Models\Role;
use Madtechservices\MadminCore\app\Models\User;
use Madtechservices\MadminCore\app\Utils\Settings\SettingsManagerController;
use Illuminate\Database\Seeder;

class MadminSeeder extends Seeder
{
    public function run()
    {
        $user = User::query()->firstOrCreate([
            'email' => 'admin@madmin.com',
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('12345678'),
            'remember_token' => null,
            'email_verified_at' => '2020-04-20 04:20:00',
            'created_at' => '2020-04-20 04:20:00',
            'updated_at' => '2020-04-20 04:20:00',
        ]);

        $role_super_admin = Role::query()->firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
            'readable_name' => 'Super Administrator',
        ]);
        $role_admin = Role::query()->firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
            'readable_name' => 'Administrator',
        ]);
        $user->assignRole($role_super_admin->name);

        $permissions = [
            [
                'group' => 'General',
                'name' => 'access-backend',
                'readable_name' => 'Can access the admin interface',
            ],
            [
                'group' => 'User',
                'name' => 'user-list',
                'readable_name' => 'Listing users',
            ],
            [
                'group' => 'User',
                'name' => 'user-show',
                'readable_name' => 'View user data',
            ],
            [
                'group' => 'User',
                'name' => 'user-create',
                'readable_name' => 'Add user',
            ],
            [
                'group' => 'User',
                'name' => 'user-update',
                'readable_name' => 'Update user',
            ],
            [
                'group' => 'User',
                'name' => 'user-delete',
                'readable_name' => 'Delete user',
            ],
            [
                'group' => 'Post',
                'name' => 'post-list',
                'readable_name' => 'Listing posts',
            ],
            [
                'group' => 'Post',
                'name' => 'post-show',
                'readable_name' => 'View post',
            ],
            [
                'group' => 'Post',
                'name' => 'post-create',
                'readable_name' => 'Add post',
            ],
            [
                'group' => 'Post',
                'name' => 'post-update',
                'readable_name' => 'Update post',
            ],
            [
                'group' => 'Post',
                'name' => 'post-delete',
                'readable_name' => 'Delete post',
            ],
            [
                'group' => 'General',
                'name' => 'activity-list',
                'readable_name' => 'Listing activities',
            ],
            [
                'group' => 'General',
                'name' => 'settings-manage',
                'readable_name' => 'View and edit settings',
            ],
            [
                'group' => 'General',
                'name' => 'roles-manage',
                'readable_name' => 'View and edit roles',
            ],
            [
                'group' => 'General',
                'name' => 'manage-all-accounts',
                'readable_name' => 'Manage all accounts'
            ]
            ];
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission['name'],
                    'guard_name' => 'web',
                    'group' => $permission['group'],
                    'readable_name' => $permission['readable_name'],
                ]);
                $role_admin->givePermissionTo($permission['name']);
            }
            
            
            $account = Account::query()->firstOrCreate([
                'name' => 'MAD Tech Services',
            ]);
            $account->users()->syncWithoutDetaching($user->id);
            
            SettingsManagerController::create([
                [
                    'name' => 'company_name',
                    'type' => 'text',
                    'tab' => 'System',
                    'label' => 'Company Name',
                    'wrapper' => [
                        'class' => 'form-group col-md-4',
                    ],
                    'value' => 'MAD Tech Services',
                ],
            ]);
            
    }
}
