<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Client as GuzzleClient;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client as ElasticsearchClient;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /* -------- PSR-18 HTTP client (Guzzle) ---------- */
        $this->app->singleton(ClientInterface::class, fn () => new GuzzleClient());

        /* -------- Cliente oficial Elasticsearch -------- */
        $this->app->singleton(ElasticsearchClient::class, function ($app) {
            $hosts = config('scout.elasticsearch.hosts', [
                'http://elasticsearch:9200',
            ]);

            return ClientBuilder::create()
                ->setHosts($hosts)                       // hosts do cluster
                ->setHttpClient($app->make(ClientInterface::class)) // Guzzle PSR-18
                ->build();
        });
    }

    public function boot(): void
    {
        //
    }
}
