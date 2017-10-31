<?php
/**
 * Created by IntelliJ IDEA.
 * User: chensink_privat
 * Date: 26.10.17
 * Time: 23:11
 */

namespace BotHub\Providers;


use BotHub\Bots\Alfred;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Api;

class BotServiceProvider extends ServiceProvider
{
    public function register()
    {
       $this->app->singleton(Alfred::class);
       $this->app->alias(Alfred::class, 'alfred');
    }
}