<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            Log::channel('single')->info('Middleware executed for user: ' . auth()->user()->id);
            User::where('id', auth()->user()->id)->update(['last_activity' => Carbon::now()]);
            $expires_after = Carbon::now()->addSeconds(5);
            Cache::put('user-online' . Auth::user()->id, true, $expires_after);
        }
        return $next($request);
    }
}
