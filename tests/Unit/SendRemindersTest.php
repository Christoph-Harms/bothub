<?php

namespace Tests\Unit;

use BotHub\Bots\Alfred;
use BotHub\Bots\Alfred\Models\Reminder;
use Carbon\Carbon;
use Telegram\Bot\Api;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendRemindersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_all_reminders_with_a_remind_at_attribute_prior_to_now()
    {
        $apiMock = \Mockery::mock(Api::class);

        $dueReminders = factory(Reminder::class, 2)->create([
            'remind_at' => Carbon::now()->subDays(5),
        ]);

        $futureReminder = factory(Reminder::class)->create([
            'remind_at' => Carbon::now()->addDays(5),
        ]);

        $apiMock->shouldReceive('addCommand');

        $apiMock->shouldReceive('sendMessage')->twice();

        $alfred = new Alfred($apiMock);

        $alfred->sendReminders();
    }
}
