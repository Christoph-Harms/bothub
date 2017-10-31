<?php

namespace Tests\Unit;

use BotHub\Bots\Alfred\Models\Reminder;
use Telegram\Bot\Api;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReminderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_persists_to_the_database()
    {
        factory(Reminder::class)->create();

        $this->assertCount(1, Reminder::all());
    }

    /** @test */
    public function it_sends_itself_to_the_user()
    {
        /** @var Reminder $reminder */
        $reminder = factory(Reminder::class)->create();

        $m = \Mockery::mock(Api::class);

        $m->shouldReceive('sendMessage')->once()
            ->with([
                'chat_id' => $reminder->chat_id,
                'text' => $reminder->message,
            ]);

        app('alfred')->swapApi($m);
        $reminder->send();
    }
}
