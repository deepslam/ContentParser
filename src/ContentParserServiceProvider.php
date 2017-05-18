<?php

namespace Deepslam\ContentParser;

use Illuminate\Support\ServiceProvider;

class ContentParserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__.'/config/parser.php' => config_path('deepslam/parser.php'),
            __DIR__.'/config/mercury.php' => config_path('deepslam/mercury.php'),
            __DIR__.'/config/graby.php' => config_path('deepslam/graby.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if (is_array(config('deepslam.parser.parsers'))) {
            ContentParser::register(config('deepslam.parser.parsers'));
        }
    }
}
