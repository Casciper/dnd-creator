<?php

namespace App\Services;
use App\Models\Page;

class GetUriService
{
    protected object $arr;
    protected string $uri;
    public function getUri($data): string
    {
        if (empty($this->arr))
        {
            $this->arr = (object)$data;
            $this->uri = '/'.$this->arr->code;
        }

        if (!empty($this->arr->parent_id)) {
            $this->uri = $this->getRecursive($this->uri, $this->arr);
            $this->getUri($this->arr);
        }

        return $this->uri;
    }

    public function getRecursive($uri, $item): string
    {
        $parent = Page::query()->where('id', $item->parent_id)->first();
        $this->arr->parent_id = $parent->parent_id;
        return '/'.$parent->code.$uri;
    }
}
