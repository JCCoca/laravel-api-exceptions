<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Forçar Resposta JSON
    |--------------------------------------------------------------------------
    | Se definido como true, o middleware incluído forçará automaticamente
    | o cabeçalho 'Accept: application/json' em todas as rotas da API.
    */
    'force_json' => true,

    /*
    |--------------------------------------------------------------------------
    | Erros e Mensagens Personalizados da API
    |--------------------------------------------------------------------------
    | Aqui você pode alterar tanto o título do erro quanto as mensagens 
    | retornadas por cada exceção HTTP da sua API.
    */
    'errors' => [
        'unauthenticated' => [
            'title' => 'Unauthenticated.',
            'message' => 'Your authentication token is invalid or expired. Please check your token.',
        ],
        'forbidden' => [
            'title' => 'Forbidden.',
            'message' => 'This action is unauthorized.',
        ],
        'not_found_resource' => [
            'title' => 'Not Found.',
            'message' => 'The requested resource was not found.',
        ],
        'not_found_endpoint' => [
            'title' => 'Not Found.',
            'message' => 'Endpoint not found.',
        ],
        'method_not_allowed' => [
            'title' => 'Method Not Allowed.',
            'message' => 'The HTTP method used is not supported for this endpoint.',
        ],
        'validation_failed' => [
            'title' => 'Unprocessable Content.',
            'message' => 'The provided data failed validation checks.',
        ],
        'database_error' => [
            'title' => 'Internal Server Error.',
            'message' => 'A database error occurred. Please try again later.',
        ],
        'fallback' => [
            'title' => 'Internal Server Error.',
            'message' => 'An unexpected error occurred on our servers. Please try again later.',
        ],
    ],
];