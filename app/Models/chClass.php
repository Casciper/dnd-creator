<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class chClass extends ProtoModel
{
    public const TABLE_NAME = 'ch_classes';
    protected $table = self::TABLE_NAME;

    public function races(): BelongsToMany
    {
        return $this->belongsToMany(Race::class, 'races_to_ch_classes', 'ch_class_id', 'race_id');
    }
}
