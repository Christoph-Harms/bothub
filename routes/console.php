<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('bots:webhooks:register', function () {
    (new \BotHub\Bots\Alfred())->setWebhook();
});

Artisan::command('bots:webhooks:delete', function () {
    (new \BotHub\Bots\Alfred())->deleteWebhook();
});

Artisan::command('bots:webhooks:info', function () {
    $info (new \BotHub\Bots\Alfred())->deleteWebhook();
});
