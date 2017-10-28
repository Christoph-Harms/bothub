<?php
/**
 * Created by IntelliJ IDEA.
 * User: chensink_privat
 * Date: 26.10.17
 * Time: 18:21
 */

namespace BotHub\Bots\Alfred\Commands;


use BotHub\Bots\Alfred;
use Carbon\Carbon;
use Telegram\Bot\Commands\Command;

class AddReminderCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "reminder";

    /**
     * @var string Command Description
     */
    protected $description = "Add a reminder. I will remind you at the specified time with the specified text.";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        try {
            $chatId = $this->getUpdate()['message']['chat']['id'];

            $alfred = new Alfred;

            if (empty($chatId)) {
                $this->replyWithMessage([
                    'text' => "Sorry, I encountered an error when trying to add the reminder. This is sad. :("
                ]);
            }

            $datetime = Carbon::parse($arguments[0]);
            $text = $arguments[1];

            $this->replyWithMessage([
                'text' => 'Ok, I will remind you to "' . $text . '" at ' . $datetime->toDateTimeString(),
            ]);

            $alfred->addReminder($chatId, $datetime, $text);
        } catch (\Throwable $throwable) {
            $this->replyWithMessage([
                'text' => "An error occured: '" . $throwable->getMessage() . "'\n\nin file " . $throwable->getFile() . ' on line ' . $throwable->getLine()
            ]);
        }
    }
}