<?php
/**
 * Created by PhpStorm.
 * User: dyangalih
 * Date: 2019-01-22
 * Time: 14:10
 */

namespace WebAppId\SmartResponse;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/', 'smartresponse');
        $this->publishes([
            __DIR__ . '/resources/lang' => $this->app->resourcePath() . '/lang'
        ], 'smartresponse');
    }
}
