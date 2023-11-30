<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends ProtoModel
{
    public const TABLE_NAME = 'characters';
    protected $table = self::TABLE_NAME;

    protected $casts = [
        'stats' => 'array',
    ];
}
