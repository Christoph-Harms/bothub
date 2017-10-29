<?php

namespace Tests\Unit;

use BotHub\Bots\Alfred\Commands\AddReminderCommand;
use/** @noinspection PhpUndefinedClassInspection */
    /** @noinspection PhpUndefinedNamespaceInspection */
    Facades\BotHub\Bots\Alfred;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AddReminderCommandTest extends TestCase
{
    public function it_tells_alfred_to_add_a_reminder()
    {
        $command = new AddReminderCommand();

        $time = "2017-12-02.20:15";

        $text = "I remind you.";

        $args = "${time} ${text}";

        /** @noinspection PhpUndefinedClassInspection */
        Alfred::shouldRecieve('addReminder')->once()->with(null, Carbon::parse($time), $text);

        $command->handle($args);



        // TODO: complete this test when we have a sensible way to mock out the telegram api
    }
}
