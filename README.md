# Laravel Error Report
Get to know what's happening in your production environment!
> [!WARNING]
> For the package to work you need to have a mail configuration set up in your Laravel application.

## What It Does
This package allows you to get e-mail notifications when an error occurs in your production environment.

## Installation
You can install the package via composer:
```bash
composer require slgo99/laravel-error-report
```
As Laravel uses Package auto-discovery, you don't need to manually add the service provider. If you don't use auto-discovery, you can add the service provider to the providers list in `bootstrap/providers.php`:
```php
return [
    App\Providers\AppServiceProvider::class,
    // ...
    Slgo99\LaravelErrorReport\ServiceProvider::class,
];
```
In older versions of Laravel, you can add the service provider to the providers list in `config/app.php`:
```php
'providers' => [
    // ...
    Slgo99\LaravelErrorReport\ServiceProvider::class,
],
```
Optionally, you can publish the configuration file with:
```bash
php artisan vendor:publish --provider="Slgo99\LaravelErrorReport\ServiceProvider" --tag="config"
```
After publishing the configuration file, you can find it in `config/error_report.php`.
```php
return [
    /**
     * Enable or disable the error report
     */
    'enabled' => env('ERROR_REPORT_ENABLED', false),

    /**
     * The emails to send the error report
     */
    'emails' => env('ERROR_REPORT_EMAILS', ''),
];
```

## Usage
To enable the e-mail notifications, you need to set the following environment variables in your `.env` file:
\
\
Enable the error report:
```env
ERROR_REPORT_ENABLED=true
```
\
Set the e-mail where you want to receive the error reports:
> [!NOTE] Note that you can set multiple e-mails separated by commas.
```env
ERROR_REPORT_EMAILS=johndoe@example.com,janedoe@example.com
```
\
\
That's it! Now you will receive an e-mail notification whenever an error occurs in your production environment.