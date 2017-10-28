<?php

namespace Tests\Unit;

use BotHub\Bots\Alfred\Models\Reminder;
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
}
