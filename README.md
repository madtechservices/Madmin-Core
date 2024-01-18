<p align="center">
    <a href="https://madtechservices.com.au/" title="madtechservices.com.au"><img src="https://raw.githubusercontent.com/madtechservices/madmin-core/main/assets/img/different-logo.png" style="max-width: 600px"></a>
<p>
  
<p align="center">
    <a href="https://packagist.org/packages/madtechservices/madmin-core" title="Latest Version on Packagist"><img src="https://img.shields.io/packagist/v/madtechservices/madmin-core.svg?style=flat-square"></a>
    <a href="https://github.com/madtechservices/madmin-core/commits/main" title="Last commit"><img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/madtechservices/madmin-core"></a>
</p>

[Documentation](https://github.com/madtechservices/madmin-core/blob/main/DOCUMENTATION.md)

## Installation

  

For a completely new project, the following commands should be run for installation:

  

> laravel new **PROJECT-NAME**  <br  />

> composer require backpack/crud<br  />

> composer require --dev backpack/generators <br  />

Create a database and add it in the `.env` file!

> php artisan backpack:install <br  />

Important: If you want to develop the madmin-core package, you need to create a `packages` folder in the root directory, and checkout the repo there!

> composer require madtechservices/madmin-core <br  />

Install Backpack PRO extension: https://backpackforlaravel.com/products/pro-for-unlimited-projects (Installation section)

> composer require backpack/pro <br  />

<br  />
<br  />

## After Installation

After running the commands, set the following values in the configuration files:

  

`config\backpack\base.php`<br  />

'view_namespace' => 'madmin-core::',<br  />

'default_date_format' => 'YYYY. MMM. D.',<br  />

'default_datetime_format' => 'YYYY. MMM. D. HH:mm',<br  />

'avatar_type' => 'getProfileImageUrl',<br  />

'guard' => null,<br  />

'passwords' => null,<br  />

'project_name' => '**PROJECT-NAME**',<br  />

'project_logo' => '**PROJECT-NAME**',<br  />

'home_link' => '', // Only for admin systems, otherwise 'admin' <br  />

'developer_name' => 'MAD Tech Services',<br  />

'developer_link' => 'https://madtechservices.com.au',<br  />

'show_powered_by' => false,<br />

<br  />

`config\app.php`<br  />

'timezone' => 'Europe/Budapest',<br  />

'locale' => 'hu',<br  />

<br  />

`config\base.php`<br />

'middleware_class' => [
    ...
    \Madtechservices\MadminCore\app\Http\Middlewares\SetLangMiddleware::class,
]

`config/backpack/crud.php`<br />

Fill in the locales here, which are the selectable languages.

`config\auth.php`<br  />

'model' => Madtechservices\MadminCore\app\Models\User::class,<br  />

<br  />

`database\seeders\DatabaseSeeder.php`<br  />


```
    public function run()
    {
        $this->call(\Madtechservices\MadminCore\Database\Seeds\MadminSeeder::class);
    }
```


<br  />

`app\Providers\RouteServiceProvider.php`<br  />

public const HOME = '/';<br  />

<br  />

**Don't forget to fill in the `.env` file correctly!**

  

After this, you just need to run the following few commands:

  

> php artisan migrate --seed<br  />

> php artisan vendor:publish --tag=config<br  />

<br  />
<br  />

## Optional packages / extensions

### Modified Backpack design

> php artisan vendor:publish --tag=scss --force

Modify the colors in the `backpack-overrides.scss` file in the `:root {` selector. To generate colors, it's worth using this: https://ionicframework.com/docs/theming/color-generator

Add a new element to the `vite.config.js` file in the laravel -> input array:<br />
> 'resources/scss/backpack-overrides.scss'

Add the new element to the `config/backpack/base.php -> vite_styles` array:<br />

'resources/scss/backpack-overrides.scss',

<br  />

> `yarn` then run `yarn dev`.

<br  />

### System level logging

Open the `app\Exceptions\Handler.php` file and modify the `register` method to this:
```
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e)) {
                store_system_logs($e);
            }
        });
    }
```

<br  />

### Larastan

The package is pre-installed but for each system, the `phpstan.neon` config file needs to be created.<br  />

https://packagist.org/packages/nunomaduro/larastan#1.0.3<br/>

Later, run `./vendor/bin/phpstan analyse` or automate it.<br/>

