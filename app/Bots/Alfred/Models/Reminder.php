<?php

namespace BotHub\Bots\Alfred\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed chat_id
 * @property mixed message
 */
class Reminder extends Model
{
    protected $fillable = [
        'chat_id',
        'message',
        'remind_at',
    ];
}
