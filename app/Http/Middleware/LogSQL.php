<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\DB;
use File;
use App\Libs\ActionLogger;

class LogSQL
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $file = storage_path('action_logs/' . "logSQL.log");
        file_put_contents($file, $request->getPathInfo() . PHP_EOL, FILE_APPEND);
        DB::enableQueryLog();
        $response = $next($request);
        foreach(DB::getQueryLog() as $query) {
            foreach ($query['bindings'] as $binding) {
                $query['query'] = preg_replace('/\?/', $binding, $query['query'], 1);
            }
            file_put_contents($file, $query['query'] . PHP_EOL, FILE_APPEND);
        }
       
        file_put_contents($file,  PHP_EOL, FILE_APPEND);
        file_put_contents($file,  PHP_EOL, FILE_APPEND);
        return $response;
    }
}

