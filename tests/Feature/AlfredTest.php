<?php

namespace Tests\Feature;

use BotHub\Bots\Alfred;
use BotHub\Jobs\Bots\Alfred\AddReminder;
use Carbon\Carbon;
use Tests\TestCase;

class AlfredTest extends TestCase
{
    /** @test */
    public function it_fetches_the_correct_token()
    {
        $alfred = new Alfred;

        $this->assertEquals(env('BOT_TOKEN_ALFRED'), $alfred->getToken());
    }

    /** @test */
    public function it_can_add_reminders()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        \Queue::fake();

        $alfred = new Alfred;

        $alfred->addReminder(1, Carbon::now()->addMinute(), "Test");

        /** @noinspection PhpUndefinedMethodInspection */
        \Queue::assertPushed(AddReminder::class);
    }
}
