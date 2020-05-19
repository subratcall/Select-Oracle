<?php

namespace App\Http\Middleware;

use App\Http\Controllers\PasswordGeneratorController;
use Closure;

if (!isset($_SESSION)) {
    session_start();
}

class CheckLogin
{
    public function handle($request, Closure $next)
    {
//        dd($_SESSION['usid']);
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            if(isset($_SESSION['password']) && $_SESSION['password'] == PasswordGeneratorController::get($_SESSION['kodeigr'])){
                return $next($request);
            }
            else{
                session_destroy();
                return response()->view('SelectOracleLogin');
            }
        }
        return redirect('select-oracle/login');
    }
}
