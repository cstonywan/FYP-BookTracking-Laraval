<?php

namespace App\Http\Middleware;

use Closure;

class UserPrivacy
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
      if (auth()->user()->role >= 1 || $request->route('id') == auth()->user()->id)
          return $next($request);
      return redirect('/b/search')->with('error', 'You are not allow to access this page');
    }
}
