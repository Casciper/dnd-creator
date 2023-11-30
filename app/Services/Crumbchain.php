<?php

namespace App\Services;

use App\DTO\CrumbDTO;
use Illuminate\Support\Collection;
use JsonSerializable;

class Crumbchain implements JsonSerializable
{
    public const ROUTE = 'web.pages.static';
    private static $instance;
    private Collection $storage;

    public function __construct()
    {
        $this->storage = collect();
    }

    public static function makeCrumb(string $title, string $url, bool $isActive = true): static
    {
        static::cs()->addCrumb(CrumbDTO::make($title, $url, $isActive));
        return static::$instance;
    }

    public function addCrumb(CrumbDTO $crumb): static
    {
        $this->storage->add($crumb);
        return $this;
    }

    /**
     * Create self or get existed instance
     * @return static
     */
    public static function cs(): static
    {
        return static::$instance ?? (static::$instance = new static());
    }

    public function getCrumbs()
    {
        return $this->storage;
    }

    public function jsonSerialize(): array
    {
        return [
            'crumbs' => $this->storage->map(fn($c) => $c->jsonSerialize()),
        ];
    }
}
