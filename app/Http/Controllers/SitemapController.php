<?php

namespace App\Http\Controllers;

use App\Services\SitemapGenerator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $fileName = '/sitemap.xml';
        $generator = new SitemapGenerator();
        $compareTime = Carbon::now()->subDay()->timestamp;
        $disk = Storage::disk('public');

        if (!$disk->exists($fileName) || $disk->lastModified($fileName) < $compareTime) {
            $mapContent = $generator->generateMap();
            $disk->put($fileName, $mapContent);
        } else {
            $mapContent = $disk->get($fileName);
        }
        return response($mapContent, 200, ['Content-Type' => 'application/xml']);
    }
}
