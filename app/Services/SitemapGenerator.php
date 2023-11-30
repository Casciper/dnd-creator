<?php

namespace App\Services;

class SitemapGenerator
{
    protected string $domain = 'http://localhost';
    protected string $head = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";
    protected string $bottom = "\n</urlset>";
    protected string $changefreq = 'weekly';
    protected string $priority = '0.6';
    protected string $map;

    public function generateMap(): string
    {
        $content = '';
        return $this->head . $content . $this->bottom;
    }

    protected function makeRow($item)
    {
        return "<url>\n  <loc>$item</loc>\n  <lastmod>" . date(DATE_ATOM) . "</lastmod>\n  <changefreq>{$this->changefreq}</changefreq>\n  <priority>{$this->priority}</priority>\n</url>\n";
    }
}
