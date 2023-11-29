<?php

namespace App\Http\Middleware;

use App\Repositories\CommonRepository;
use Closure;
use Illuminate\Http\Request;

class GetCommonDateAtStartup
{
    public function handle(Request $request, Closure $next)
    {
        $configsData = CommonRepository::take()->getConfigurationData()->toArray();

        if (!empty($configsData)) {
            $configs = [];
            foreach ($configsData as $datum) {
                $configs['rocont.' . $datum['key']] = $datum['value'];
            }
            config($configs);
        }

        return $next($request);
    }
}
