<?php

namespace App\Models;

use App\Interfaces\ProtoInterface;
use App\Traits\CodeScopeTrait;
use App\Traits\IsActiveScopeTrait;
use App\Traits\SortedByPublicationScopeTrait;
use App\Traits\SortedScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

abstract class ProtoModel extends Model implements ProtoInterface
{
    use HasFactory;
    use AsSource;
    use Attachable;
    use Filterable;
    use SortedScopeTrait;
    use IsActiveScopeTrait;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getTitle()
    {
        return $this->title ?? $this->name;
    }

    public function getIdentifier()
    {
        return $this->code ?? $this->slug;
    }

    public function getCode()
    {
        return $this->code ?? $this->slug;
    }
}
