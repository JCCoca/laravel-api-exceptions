# Laravel API Exceptions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jccoca/laravel-api-exceptions.svg?style=flat-square)](https://packagist.org/packages/jccoca/laravel-api-exceptions)
[![Total Downloads](https://img.shields.io/packagist/dt/jccoca/laravel-api-exceptions.svg?style=flat-square)](https://packagist.org/packages/jccoca/laravel-api-exceptions)
[![License](https://img.shields.io/github/license/JCCoca/laravel-api-exceptions.svg?style=flat-square)](LICENSE)

🇧🇷 **[Para a versão em Português, clique aqui](./README.pt-BR.md)**

A lightweight and elegant package to standardize and customize HTTP error and exception responses in **Laravel 11, 12, and 13+** REST APIs.

## ✨ Features

- ⚡ **Auto-Format Errors:** Catch common API errors (401, 403, 404, 405, 422, 500) and return a consistent JSON payload structure.
- ⚙️ **Highly Customizable:** Easily change both the error title (`error`) and the explanation (`message`) for any exception using a simple config file.
- 🛠️ **Force JSON Middleware:** Automatically forces all `/api` prefixed routes to return `application/json` transparently.
- 🐛 **Smart Debugging:** Shows file, line, and a clean, simplified stack trace when `APP_DEBUG=true`.
- 🛡️ **Production-Safe:** Automatically hides database details and PHP error messages when the application is in production mode.

---

## 🚀 Installation

You can install the package via Composer:

```bash
composer require jccoca/laravel-api-exceptions
```

---

## 🛠️ Configuration

### 1. Bind the Handler in Laravel

Open your Laravel application's bootstrap/app.php file and call the handler inside the withExceptions block:

```PHP
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use JCCoca\ApiExceptions\Http\Middleware\ForceJsonResponse;
use JCCoca\ApiExceptions\Exceptions\Handlers\ApiExceptionHandler;

return Application::configure(basePath: dirname(__DIR__))
    // ...
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(append: [
            // Append the Force JSON middleware to the api group
            ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Binds the smart API exception handler
        ApiExceptionHandler::bind($exceptions);
    })->create();
```

### 2. Publish Configuration (Optional)

If you want to translate or change the default error titles and messages, publish the config file using the Artisan command:

```bash
php artisan vendor:publish --tag=api-exceptions-config
```
This will create a config/api-exceptions.php file in your project.

---

## 📝 Default Output Formats (Examples)

Validation Error (422 Unprocessable Content)

```JSON
{
  "error": "Unprocessable Content.",
  "message": "The provided data failed validation checks.",
  "errors": {
    "sort_direction": [
      "The selected sort direction is invalid."
    ]
  }
}
```

Too Many Requests Error (429 Rate Limit)

```JSON
{
  "error": "Too Many Requests.",
  "message": "You have exceeded your rate limit. Please try again later."
}
```

Integration / External API Error (502 Bad Gateway - Debug Enabled)

```JSON
{
  "error": "Bad Gateway.",
  "message": "An error occurred while communicating with an upstream service.",
  "debug": {
    "upstream_status": 500,
    "upstream_url": "https://api.external-service.com/v1/users",
    "upstream_response": {
      "success": false,
      "message": "Fatal database failure in external service."
    }
  }
}
```

Internal Server Error (500 with Debug Enabled)

```JSON
{
  "error": "Internal Server Error.",
  "message": "Division by zero",
  "debug": {
    "exception": "DivisionByZeroError",
    "file": "/var/www/html/app/Http/Controllers/UserController.php",
    "line": 42,
    "trace": [
      {
        "file": "/var/www/html/app/Http/Controllers/UserController.php",
        "line": 42,
        "function": "index",
        "class": "App\\Http\\Controllers\\UserController"
      }
    ]
  }
}
```