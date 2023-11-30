<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class RobotsTxtController extends Controller
{
    public function __invoke()
    {
        $defaultContent = app()->isProduction()
            ? 'User-agent: *' . PHP_EOL . 'Disallow: /admin/' . PHP_EOL . 'Host: ' . url('/')
            : 'User-agent: *' . PHP_EOL . 'Disallow: /';

        $content = Storage::disk('public')->get('robots.txt') ?? $defaultContent;
        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
