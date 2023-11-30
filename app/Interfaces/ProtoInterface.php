<?php

namespace App\Interfaces;

interface ProtoInterface
{
    public function fill(array $attributes);

    public function save();

    public function delete();
}
