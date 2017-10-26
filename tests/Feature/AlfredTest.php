<?php

namespace Tests\Feature;

use BotHub\Bots\Alfred;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlfredTest extends TestCase
{
    /** @test */
    public function it_fetches_the_correct_token()
    {
        $alfred = new Alfred;

        $this->assertEquals(env('BOT_TOKEN_ALFRED'), $alfred->getToken());
    }
}
