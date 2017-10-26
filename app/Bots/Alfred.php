<?php
/**
 * Created by IntelliJ IDEA.
 * User: chensink_privat
 * Date: 26.10.17
 * Time: 17:32
 */

namespace BotHub\Bots;


use BotHub\Bot;
use BotHub\Bots\Alfred\Commands\StartCommand;

class Alfred extends Bot
{

    /**
     * Alfred constructor.
     */
    public function  __construct()
    {
        parent::__construct();
        $this->addCommand(StartCommand::class);
    }
}