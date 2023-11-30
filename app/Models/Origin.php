<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origin extends ProtoModel
{
    public const TABLE_NAME = 'origins';
    protected $table = self::TABLE_NAME;
}
