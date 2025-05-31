<?php
namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if (auth()->user()->is_admin) {
            session()->flash('success', 'Welcome back, Admin!');
            return redirect()->route('admin.dashboard');
        }
        session()->flash('success', 'Welcome back!');
        return redirect()->intended('/');
    }
}
