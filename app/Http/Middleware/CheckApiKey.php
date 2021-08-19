<?php

namespace App\Http\Middleware;

use App\models\Api_settings;
use App\Traits\ApiResponse;
use Closure;

class CheckApiKey
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if (!$request->filled('api_key') || !$request->filled('api_token')) {
            return $this->errorResponse('Error, la API KEY/API TOKEN debe estar presente.',401);
        }
        $params = $request->all();
        $Api_settings = Api_settings::where('api_key', $params['api_key'])
                                    ->where('api_token', $params['api_token'])
                                    ->first(); 
        
        if (is_null($Api_settings)) {
            return $this->errorResponse('Error, API KEY/API TOKEN no autorizada',401);
        }

        return $next($request);
    }
}
