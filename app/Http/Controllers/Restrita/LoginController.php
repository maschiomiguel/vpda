<?php

declare(strict_types=1);

namespace App\Http\Controllers\Restrita;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Orchid\Platform\Http\Controllers\LoginController as ControllersLoginController;

class LoginController extends ControllersLoginController
{
    public function login(Request $request)
    {
        $request->validate([
            'username'    => 'required|string',
            'password' => 'required|string',
        ]);

        $auth = $this->guard->attempt(
            $request->only(['username', 'password']),
            $request->filled('remember')
        );

        if ($auth) {
            return $this->sendLoginResponse($request);
        }

        throw ValidationException::withMessages([
            'username' => __('The details you entered did not match our records. Please double-check and try again.'),
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson() ? new JsonResponse([], 204) : redirect('/panel');
    }
}
