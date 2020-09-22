<?php

namespace App\Http\Middleware;

use Closure;

class VerifyUnsubscribeRoute
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
    if (!$request->hasValidSignature()) {
      abort(401);
    } else {
      return $next($request);
    }
  }
}
