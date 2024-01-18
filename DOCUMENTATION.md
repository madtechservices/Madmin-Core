# Documentation

## Delete modal / pop-up

This code snippet needs to be placed in the respective CRUD **setup()** method.

```
use Madtechservices\MadminCore\app\Http\Controllers\Operations\DeleteOperation;

public function setup() {
    // ...
    $this->crud->data['delete_modal'] = [
        'title' => __('madmin-core::users.delete_title'),
        'text' =>  __('madmin-core::users.delete_text'),
    ];
    // ...
}

# Documentation

## Delete modal / pop-up

This code snippet needs to be placed in the respective CRUD **setup()** method.
# Documentation

## Delete modal / pop-up

This code snippet needs to be placed in the respective CRUD **setup()** method.

```


## File / image upload field

Example code can be found here for profile image upload: **Madtechservices\MadminCore\app\Models\User.php**

**'name': field specification is mandatory**, it's important that it's the same as the relation.

AYou need to override the `store` and `update` methods and call `$this->handleFileUpload();` in the first line.

In the model (e.g., User), you need to handle that if the row is deleted, the file is also deleted with it. (e.g., Madtechservices\MadminCore\app\Models\User.php -> boot())

If you want a preview as well (in case of an image), you need to set the 'has_preview' parameter value to true.

**IMPORTANT: To make the file upload work, it is mandatory to specify `'upload' => true`. This is because of Backpack. At the database level, you need to make sure there is no cascade delete because then the file will be deleted along with the item we are currently editing.**

```
[
    'name' => 'profile_image', // Relation
    'label' => __('madmin-core::users.profile_image'), // Title
    'view_namespace' => 'madmin-core::fields', // MANDATORY
    'type' => 'file', // MANDATORY
    'has_preview' => true, // If it's an image, set to true
    'upload' => true, // MANDATORY
    'wrapper' => [ // Optional
        'class' => 'form-group col-12',
    ],
],
```

## Sidebar / menu

You can add new menu items in the following file: **config/madmin-core/config.php**

### Menu item


```
new SidebarMenuItem(
    '/admin/songs', // Reference
    'songs.songs', // Translatable title
    'las la-music', // Icon (https://icons8.com/line-awesome)
    // 'song', // Permission for displaying the menu item
),
```

### Group
```
new SidebarMenuGroup(
    'madmin-core::sidebar.system', // Translatable title
    [
        // Array of menu items, for example:
        new SidebarMenuItem(route('admin.user.index'), 'madmin-core::users.users', 'las la-user', 'user-list'),
        new SidebarMenuItem(route('admin.account.index'), 'madmin-core::accounts.accounts', 'las la-users', 'account-list'),
        new SidebarMenuItem(route('admin.role.index'), 'madmin-core::roles.roles', 'las la-id-badge', 'role-manage'),
        new SidebarMenuItem(route('admin.activity.index'), 'madmin-core::activities.activities', 'las la-history', 'activity-list'),
        new SidebarMenuItem(route('admin.settings'), 'madmin-core::settings.settings', 'las la-sliders-h', 'setting-manage'),
        new SidebarMenuItem(route('admin.documentation'), 'madmin-core::documentation.documentation', 'las la-book', 'documentation-read'),
    ],
    'las la-cog', // Ikon (https://icons8.com/line-awesome)
    [
        // Permission to display the group, if the user has at least one of these, then the group will be displayed 'user-list',
        'role-manage',
        'activity-list',
        'setting-manage',
        'documentation-read',
    ]
),
```

### Label

```
new SidebarMenuLabel(
    'Label',
    [
        'user-list',
    ],
);
```

## "Breadcrumbs" menu

You need to put this code snippet into the respective CRUD **setup()** method.
```
use Madtechservices\MadminCore\app\Utils\Breadcrumb\BreadcrumbMenuItem;

$this->data['breadcrumbs_menu'] = [
    new BreadcrumbMenuItem(
        backpack_url('dashboard'), 
        __('backpack::crud.admin'), 
        'las la-tachometer-alt', // (https://icons8.com/line-awesome)
    ),
];
```

## "Tabs" menu

You need to put this code snippet into the respective CRUD **setup()** method.
```
use Madtechservices\MadminCore\app\Utils\Tab\TabItem;

$this->data['tabs'] = [
    new TabItem(
        route('songs.index'),
        __('songs.songs'),
        'las la-music',
        'song.list',
        false,
        true,
        true,
        true,
        true
    ),
    new TabItem(
        route('admin.user.index'),
        __('madmin-core::users.users'),
        'las la-user',
        'user.list',
        false,
        true,
        true,
        true,
        true
    ),
];
```

## CRUD permissions

This code snippet needs to be placed in the respective CRUD **setup()** method.

It disables certain CRUD operations if there is no permission starting with $name. For example, in the case of a user, the following permissions: user-list, user-show, user-delete, etc.

```
crud_permissions($this->crud, 'need_the_permission');
```

Disables all CRUD operations if the user does not have this permission.
```
crud_permission($this->crud, 'need_the_permission');
```

## General Permission Management

Does the user have the permission passed.

```
user_can('need_the_permission');
```

Does the user have at least one of the passed permissions.


```
user_can_any(['first_permission', 'second_permission']);
```

## Settings

The seeder file should be prepared in such a way that it will run every time the system is deployed.

A new setting should be added to the seeder file as follows:

```
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
```

If a setting is no longer in use later, the following line should be added to the seeder so that it is deleted:
```
SettingsManagerController::delete('company_name');
```

To retrieve a setting, use the following function:

```
SettingsManagerController::get('company_name');
```

If you want to modify the value of the setting from the code later, then:

```
SettingsManagerController::set('company_name', 'new company name');
```
