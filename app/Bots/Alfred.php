<?php
/**
 * Created by IntelliJ IDEA.
 * User: chensink_privat
 * Date: 26.10.17
 * Time: 17:32
 */

namespace BotHub\Bots;


use BotHub\Bot;
use BotHub\Bots\Alfred\Commands\AddReminderCommand;
use BotHub\Bots\Alfred\Commands\QuoteCommand;
use BotHub\Bots\Alfred\Commands\StartCommand;
use BotHub\Bots\Alfred\Models\Reminder;
use BotHub\Jobs\Bots\Alfred\AddReminder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Telegram\Bot\Api;

class Alfred extends Bot
{

    /**
     * Alfred constructor.
     * @param Api|null $api
     */
    public function  __construct(Api $api = null)
    {
        parent::__construct(null, $api);
        $this->addCommand(StartCommand::class);
        $this->addCommand(QuoteCommand::class);
        $this->addCommand(AddReminderCommand::class);
    }

    public function addReminder(int $chatId, Carbon $remindAt, string $message)
    {
        AddReminder::dispatch($chatId, $remindAt, $message);
    }

    public function sendReminders()
    {
        /** @var Collection $dueReminders */
        $dueReminders = Reminder::whereDate('remind_at', '<', Carbon::now())->get();


        $dueReminders->each(function ($reminder) {

            $text = "You wanted to be reminded, so here is your reminder:\n\n" . $reminder->message;
            /** @var Reminder $reminder */
            $this->sendMessage($reminder->chatId, $text);
        });
    }
}