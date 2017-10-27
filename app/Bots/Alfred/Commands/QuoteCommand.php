<?php
/**
 * Created by IntelliJ IDEA.
 * User: chensink_privat
 * Date: 26.10.17
 * Time: 18:21
 */

namespace BotHub\Bots\Alfred\Commands;


use Illuminate\Foundation\Inspiring;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class QuoteCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "quote";

    /**
     * @var string Command Description
     */
    protected $description = "Output a random, inspiring quote";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $quote = Inspiring::quote();
        $this->replyWithMessage(['text' => $quote]);
    }
}