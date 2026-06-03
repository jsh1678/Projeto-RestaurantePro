<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Informe seu e-mail.',
            'email.email'       => 'Informe um e-mail válido.',
            'password.required' => 'Digite sua senha.',
        ]);

        // Busca usuário pelo email + ativo (sem precisar informar cargo)
        $user = User::where('email', $validated['email'])
            ->where('ativo', true)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'E-mail não encontrado ou conta inativa.'])
                ->onlyInput('email');
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors(['password' => 'Senha incorreta.'])
                ->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Redireciona para a área correspondente ao cargo
        $destino = match ($user->role) {
            'garcom' => route('mesas.index'),
            'chef'   => route('chef.preparo'),
            'caixa'  => route('caixa.dashboard'),
            default  => route('dashboard'),
        };

        return redirect()->intended($destino);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
