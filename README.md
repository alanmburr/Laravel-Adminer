# Laravel-Adminer
Laravel 10 wrapper for [Adminer](https://github.com/vrana/adminer/).
Adminer is an excellent database management tool in a single PHP file written by Jakub Vrana. It's a great replacement for PhpMyAdmin (also supports PostgreSQL, SQLite, MSSQL, Oracle, Firebird, SimpleDB, Elasticsearch and MongoDB).

## Note
This package was originally built for Laravel 5, so some *information* may be outdated. However, the package should still function properly.

## Usage
To include the library, go to your project's folder and run:
```bash
composer require "alanmburr/laravel-adminer"
```

To add adminer to Laravel routes (e.g. /adminer), update `routes/web.php` file with:
```php
Route::any('adminer', [\AlanMBurr\LaravelAdminer\AdminerController::class, 'index']);
```

To autologin Adminer with Laravel default connection, add the following controller instead:
```php
Route::any('adminer', [\AlanMBurr\LaravelAdminer\AdminerAutologinController::class, 'index']);
```

### Disabling CSRF Middleware
Adminer doesn't work with VerifyCsrfToken middleware, so it has to be disabled on its route.
#### Laravel 5.1+
In `VerifyCsrfToken.php` disable CSRF by adding adminer route to `$except` array:
```php
protected $except = [
    'adminer'
];
```

#### Laravel 5.0
The easiest way is to create a custom VerifyCsrfToken middleware that excludes selected routes:
```php
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class CustomVerifyCsrfToken extends VerifyCsrfToken {

    protected $excludedRoutes = ['adminer'];

	public function handle($request, Closure $next)
	{
        if ($this->isExcludedRoute($request)){
            return $next($request);
        } else {
            return parent::handle($request, $next);
        }
	}

    private function isExcludedRoute($request)
    {
        if (count($request->segments()) > 0
            && in_array($request->segment(1), $this->excludedRoutes)){
            return true;
        } else {
            return false;
        }
    }
}

```

And then use that instead of `VerifyCsrfToken` in `Kernel.php`
```php
protected $middleware = [
	'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
	'Illuminate\Cookie\Middleware\EncryptCookies',
	'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
	'Illuminate\Session\Middleware\StartSession',
	'Illuminate\View\Middleware\ShareErrorsFromSession',
	'Path\To\CustomVerifyCsrfToken',
];
```


## Remarks
Due to function name conflicts of Laravel5 and Adminer, adminer.php file 
functions  'cookie()', 'redirect()' and 'view()' are prefixed with 'adm_' prefix.

If you find any problem, please let me know.
