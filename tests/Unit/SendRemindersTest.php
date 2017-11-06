<?php

namespace Tests\Unit;

use BotHub\Bots\Alfred;
use BotHub\Bots\Alfred\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendRemindersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_all_reminders_with_a_remind_at_attribute_prior_to_now()
    {
        $apiMock = $this->getApiMock();


        /** @var Collection $dueReminders */
        $dueReminders = factory(Reminder::class, 2)->create([
            'remind_at' => Carbon::now()->subDays(5),
        ]);

        /** @var Reminder $futureReminder */
        $futureReminder = factory(Reminder::class)->create([
            'remind_at' => Carbon::now()->addDays(5),
        ]);

        $sendMessageArgs = $dueReminders->map(function ($item) {
            /** @var Reminder $item */
            return [
                'chat_id' => $item->chat_id,
                'text' => $item->message,
            ];
        });

        $apiMock->shouldReceive('sendMessage')->with($sendMessageArgs[0]);
        $apiMock->shouldReceive('sendMessage')->with($sendMessageArgs[1]);
        $apiMock->shouldNotReceive('sendMessage')->with([
            'chat_id' => $futureReminder->chat_id,
            'text' => $futureReminder->message,
        ]);

        $this->app->instance('telegram', $apiMock);
        $alfred = new Alfred();

        $alfred->sendReminders();
    }

    /**
     * @return \Mockery\MockInterface
     */
    public function getApiMock(): \Mockery\MockInterface
    {
        $apiMock = \Mockery::mock(Api::class);
        $apiMock->shouldReceive('addCommand', 'setAccessToken');
        return $apiMock;
    }
}
