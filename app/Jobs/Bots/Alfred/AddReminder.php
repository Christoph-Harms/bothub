<?php

namespace BotHub\Jobs\Bots\Alfred;

use BotHub\Bots\Alfred\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $remindAt;
    protected $chatId;

    /**
     * Create a new job instance.
     *
     * @param int $chatID
     * @param Carbon $remindAt
     * @param string $message
     */
    public function __construct(int $chatID, Carbon $remindAt, string $message)
    {
        $this->chatId = $chatID;
        $this->remindAt = $remindAt;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reminder = new Reminder([
            'chat_id' => $this->chatId,
            'message' => $this->message,
            'remind_at' => $this->remindAt,
        ]);

        \Log::info("Creating new reminder: " . json_encode($reminder));

        $reminder->save();
    }
}
