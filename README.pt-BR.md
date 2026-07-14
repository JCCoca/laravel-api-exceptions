# Laravel API Exceptions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jccoca/laravel-api-exceptions.svg?style=flat-square)](https://packagist.org/packages/jccoca/laravel-api-exceptions)
[![Total Downloads](https://img.shields.io/packagist/dt/jccoca/laravel-api-exceptions.svg?style=flat-square)](https://packagist.org/packages/jccoca/laravel-api-exceptions)
[![License](https://img.shields.io/github/license/JCCoca/laravel-api-exceptions.svg?style=flat-square)](LICENSE)

🇺🇸 **[For the English version, click here](./README.md)**

Um pacote leve e elegante para padronizar e customizar as respostas de erros e exceções HTTP em APIs REST do **Laravel 11, 12 e 13+**.

## ✨ Recursos

- ⚡ **Auto-Formatador de Erros:** Captura erros comuns de APIs (401, 403, 404, 405, 422, 500) e retorna um padrão JSON idêntico.
- ⚙️ **Altamente Customizável:** Altere facilmente o título (`error`) e a mensagem (`message`) de qualquer erro através de um arquivo de configuração simples.
- 🛠️ **Middleware de Forçamento de JSON:** Força todas as respostas de rotas com prefixo `/api` a retornarem `application/json` de forma transparente.
- 🐛 **Debug Inteligente:** Mostra arquivo, linha e pilha de execução (*stack trace*) simplificada quando o `APP_DEBUG=true`.
- 🛡️ **Seguro em Produção:** Oculta dados de banco de dados e erros do PHP se o ambiente estiver em modo de produção.

---

## 🚀 Instalação

Você pode instalar o pacote via Composer:

```bash
composer require jccoca/laravel-api-exceptions
```

---

## 🛠️ Configuração

### 1. Vincular o Handler no Laravel

Abra o arquivo bootstrap/app.php do seu projeto Laravel e adicione a chamada do Handler dentro do bloco withExceptions:


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
            // Adiciona o middleware Force JSON ao grupo 'api'
            ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Vincula o tratamento inteligente de erros de API
        ApiExceptionHandler::bind($exceptions);
    })->create();
```

### 2. Publicar as Configurações (Opcional)

Se desejar traduzir ou alterar as mensagens de erro e títulos padrões, publique o arquivo de configuração do pacote usando o comando do Artisan:

```bash
php artisan vendor:publish --tag=api-exceptions-config
```

Isso criará o arquivo config/api-exceptions.php no seu projeto.

---

## 📝 Formato de Retorno Padrão (Exemplos)

Erro de Validação (422 Unprocessable Content)

```JSON
{
  "error": "Unprocessable Content.",
  "message": "The provided data failed validation checks.",
  "errors": {
    "sort_direction": [
      "A direção da ordenação selecionada é inválida."
    ]
  }
}
```

Excesso de Requisições (429 Too Many Requests)

```JSON
{
  "error": "Too Many Requests.",
  "message": "You have exceeded your rate limit. Please try again later."
}
```

Erro de Integração Externa (502 Bad Gateway - Debug Habilitado)

```JSON
{
  "error": "Bad Gateway.",
  "message": "An error occurred while communicating with an upstream service.",
  "debug": {
    "upstream_status": 500,
    "upstream_url": "https://api.external-service.com/v1/users",
    "upstream_response": {
      "success": false,
      "message": "Falha crítica de banco de dados no serviço externo."
    }
  }
}
```

Erro Interno do Servidor (500 com Debug Habilitado)

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