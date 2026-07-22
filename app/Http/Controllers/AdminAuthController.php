<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function loginForm()
    {
        return view('admin.login');
    }

    /**
     * Connexion de l'administrateur.
     */
    public function login(LoginRequest $request)
    {
        try {

            $request->authenticate();

        } catch (ValidationException $e) {

            return back()
                ->withErrors($e->errors())
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Déconnexion.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}