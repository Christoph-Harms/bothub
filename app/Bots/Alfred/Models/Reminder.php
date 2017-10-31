<?php

namespace BotHub\Bots\Alfred\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed chat_id
 * @property mixed message
 */
class Reminder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'chat_id',
        'message',
        'remind_at',
    ];

    protected function getMessagePrefix()
    {
        return __('bots/alfred.reminders.message-prefix');
    }

    protected function getMessageAttribute($message)
    {
        return $this->getMessagePrefix() . "\n\n" . $message;
    }

    public function send()
    {
       app('alfred')->sendMessage($this->chat_id, $this->message);
    }
}
