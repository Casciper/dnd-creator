<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Race extends ProtoModel
{
    public const TABLE_NAME = 'races';
    protected $table = self::TABLE_NAME;
    protected $casts = [
        'data' => 'array',
    ];

    public function genders(): BelongsToMany
    {
        return $this->belongsToMany(Gender::class, 'races_to_genders', 'race_id', 'gender_id');
    }

    public function chClasses(): BelongsToMany
    {
        return $this->belongsToMany(chClass::class, 'races_to_ch_classes', 'race_id', 'ch_class_id');
    }
}
