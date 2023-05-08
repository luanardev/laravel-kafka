<?php

namespace Luanardev\LaravelKafka;
use Illuminate\Support\ServiceProvider;

class KafkaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $queue = $this->app['queue'];
        $queue->addConnector('kafka', function (){
            return new KafkaConnector();
        });
    }
	
}
