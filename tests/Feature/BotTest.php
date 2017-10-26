<?php

namespace Tests\Feature;

use Telegram\Bot\Objects\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BotTest extends TestCase
{
    const TG_TOKEN = "316838507:AAF4KeNhDPWPS6tIdaM1u9b4_-xYgFUXZhc";
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_connects_to_the_telegram_api()
    {
        $bot = new \BotHub\Bot(self::TG_TOKEN);

        $res = $bot->getMe();

        $this->assertInstanceOf(User::class, $res, "getMe() didn't return an instance of " . User::class);
    }
}
