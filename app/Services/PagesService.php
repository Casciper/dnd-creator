<?php

namespace App\Services;

class PagesService
{
    function getLastParent($page)
    {
        if ($page->parentRecursive) {
            return $this->getLastParent($page->parentRecursive);
        } else {
            return $page;
        }
    }
}
