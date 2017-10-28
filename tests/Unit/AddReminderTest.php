<?php

namespace Tests\Unit;

use BotHub\Jobs\Bots\Alfred\AddReminder;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddReminderTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   public function it_creates_a_new_reminder_in_the_databasd()
   {
       $remindTime = Carbon::now()->addMinutes(10);
       $message = "You wanted to be reminded.";

       $job = new AddReminder(1, $remindTime, $message);

       $job->handle();

       $this->assertDatabaseHas('reminders', [
           'chat_id' => 1,
           'remind_at' => $remindTime,
           'message' => $message,
       ]);
   }
}
