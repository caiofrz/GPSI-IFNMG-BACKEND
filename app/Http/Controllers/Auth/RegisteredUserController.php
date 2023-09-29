<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'matriculaSiape' => ['required', 'integer', 'digits:7'],
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cargo' => ['required', 'string', 'max:45'],
            'isAdmin' => ['required', 'boolean'],
            'isSuperAdmin' => ['required', 'boolean'],
            'foto' => ['string'],
        ]);

        $user = User::create([
            'matriculaSiape' => $request->matriculaSiape,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cargo' => $request->cargo,
            'isAdmin' => $request->isAdmin,
            'isSuperAdmin' => $request->isSuperAdmin,
            'foto' => $request->foto,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
