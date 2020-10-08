<?php
/**
 * Created by PhpStorm.
 * User: dyangalih
 * Date: 2019-01-22
 * Time: 14:10
 */

namespace WebAppId\SmartResponse;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/resources/lang' => $this->app->resourcePath() . '/lang'
        ], 'smartresponse');

        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/', 'smartresponse');
    }
}
