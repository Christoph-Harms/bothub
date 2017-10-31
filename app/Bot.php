<?php
/**
 * Created by IntelliJ IDEA.
 * User: chensink_privat
 * Date: 26.10.17
 * Time: 15:43
 */

namespace BotHub;


use BotHub\Exceptions\BotHubException;
use Telegram\Bot\Api;

/**
 * Class Bot
 * @package BotHub
 */
class Bot
{
    /**
     * @var string
     */
    protected $token;
    /**
     * @var Api
     */
    protected $api;

    /**
     * Bot constructor.
     * @param string $token
     * @param Api|null $api
     */
    public function __construct(string $token = null, Api $api = null)
    {
        $this->token = $token ?? $this->fetchToken() ?? $this->panic('Unable to fetch token.');
        $this->api = $api ?? app('telegram');
        $this->api->setAccessToken($this->token);
    }

    /**
     * @return \Telegram\Bot\Objects\User
     */
    public function getMe()
    {
        return $this->api->getMe();
    }

    /**
     * @return mixed
     */
    protected function fetchToken()
    {
        return env('BOT_TOKEN_' . strtoupper($this->getName()), null);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    public function getPath()
    {
        return base64_encode($this->getToken());
    }

    public function addCommand($command)
    {
        $this->api->addCommand($command);
    }

    public function handle($webhook = true)
    {
        return $this->api->commandsHandler($webhook);
    }

    public function setWebhook()
    {
        $this->api->setWebhook([
                'url' => url($this->getPath()),
            ]);
    }

    public function deleteWebhook()
    {
        $this->api->removeWebhook();
    }

    public function sendMessage($chatId, $message)
    {
        return $this->api->sendMessage(
            [
                'chat_id' => $chatId,
                'text' => $message,
            ]
        );
    }

    public function swapApi(Api $api)
    {
        $this->api = $api;
    }

    protected function getName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * @param $message
     * @throws BotHubException
     */
    protected function panic($message)
    {
        throw new BotHubException($message);
    }
}