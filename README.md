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
