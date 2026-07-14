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