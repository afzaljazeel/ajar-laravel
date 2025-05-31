<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        session()->flash('success', 'Account created successfully!');
        return redirect()->intended('/'); // Redirect to intended or homepage
    }



}
