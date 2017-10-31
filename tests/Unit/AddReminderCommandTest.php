<?php

namespace Tests\Unit;

use BotHub\Bots\Alfred\Commands\AddReminderCommand;
use BotHub\Jobs\Bots\Alfred\AddReminder;
use/** @noinspection PhpUndefinedClassInspection */
    /** @noinspection PhpUndefinedNamespaceInspection */
    Facades\BotHub\Bots\Alfred;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AddReminderCommandTest extends TestCase
{
    /** @test */
    public function it_confirms_the_reminder_to_the_chat()
    {
        $command = new AddReminderCommand();

        $time = "2017-12-02 20:15:00";

        $text = "I remind you.";

        $args = "${time} -- ${text}";

        $m = \Mockery::mock(Api::class);

        $m->shouldReceive('sendMessage')->once()
            ->with([
                'chat_id' => 666,
                'text' => 'Ok, I will remind you to "' . $text . '" at ' . Carbon::parse($time)->toDateTimeString(),
            ]);

        $command->make($m, $args, (new Update([
            'message' => [
                'chat' => [
                    'id' => 666
                ]
            ]
        ])));
    }

    /** @test */
    public function it_tells_alfred_to_add_a_reminder()
    {
        $command = new AddReminderCommand();

        $time = "2017-12-02 20:15:00";

        $text = "   I remind you.";

        $args = "${time} -- ${text}";

        $m = \Mockery::mock(Api::class);

        $m->shouldReceive('sendMessage')->once();

        \Queue::fake();

        $command->make($m, $args, (new Update([
            'message' => [
                'chat' => [
                    'id' => 666
                ]
            ]
        ])));

        \Queue::assertPushed(AddReminder::class, function ($job) use ($time, $text) {
            /** @var AddReminder $job */
            return $job->chatId === 666
                && $job->message === trim($text)
                && $job->remindAt->eq(Carbon::parse($time));
        });
    }
}
