<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $loader =  '
            <div id="loadingScreen" style="">
                <div class="pixel-loader"></div>
            </div>
            ';
        echo $loader;
        echo '<script>
            document.addEventListener("DOMContentLoaded", () => {
                document.getElementById("loadingScreen").remove();

            });
            </script>';
        if (session()->has('adminAuth')) {
            return $next($request);
        } else {
            return redirect('/login');
        }
    }
}
