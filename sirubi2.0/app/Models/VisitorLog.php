<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $table = 'visitor_logs';

    public $timestamps = false;

    protected $fillable = [
        'ip',
        'url',
        'user_agent',
        'visited_at',
    ];
}
