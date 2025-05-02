<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    | Estamos usando o driver “elastic” do pacote matchish/laravel-scout-elasticsearch
    */
    'driver' => env('SCOUT_DRIVER', 'elastic'),

    /*
    |--------------------------------------------------------------------------
    | Configurações específicas do driver “elastic”
    |--------------------------------------------------------------------------
    */
    'elastic' => [
        'hosts' => explode(
            ',',
            env('SCOUT_ELASTICSEARCH_HOSTS', 'http://elasticsearch:9200')
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Outras opções padrão do Scout
    |--------------------------------------------------------------------------
    */
    'prefix'       => env('SCOUT_PREFIX', ''),
    'queue'        => env('SCOUT_QUEUE', false),
    'after_commit' => false,

    'chunk' => [
        'searchable'   => 500,
        'unsearchable' => 500,
    ],

    'soft_delete' => false,
    'identify'    => env('SCOUT_IDENTIFY', false),

    /*
    |--------------------------------------------------------------------------
    | Configurações de outros drivers (Algolia, Meili, Typesense…)
    |--------------------------------------------------------------------------
    */
    'algolia'     => [
        'id'     => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
        'key'  => env('MEILISEARCH_KEY'),
    ],

    'typesense'   => [
        'client-settings' => [
            'api_key' => env('TYPESENSE_API_KEY', 'xyz'),
            'nodes'   => [[
                'host'     => env('TYPESENSE_HOST', 'localhost'),
                'port'     => env('TYPESENSE_PORT', '8108'),
                'path'     => env('TYPESENSE_PATH', ''),
                'protocol' => env('TYPESENSE_PROTOCOL', 'http'),
            ]],
        ],
    ],

];
