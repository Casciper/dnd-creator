<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Gender extends ProtoModel
{
    public const TABLE_NAME = 'genders';
    protected $table = self::TABLE_NAME;

    public function races(): BelongsToMany
    {
        return $this->belongsToMany(Race::class, 'races_to_genders', 'gender_id', 'race_id');
    }
}
