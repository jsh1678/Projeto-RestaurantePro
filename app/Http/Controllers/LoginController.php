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
            'role'     => 'required|in:gerente,garcom,chef,caixa',
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'role.required'     => 'Selecione um cargo.',
            'role.in'           => 'Cargo inválido.',
            'email.required'    => 'Informe seu e-mail.',
            'email.email'       => 'Informe um e-mail válido.',
            'password.required' => 'Digite sua senha.',
        ]);

        // Busca usuário pelo email + cargo + ativo
        $user = User::where('role', $validated['role'])
            ->where('email', $validated['email'])
            ->where('ativo', true)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'E-mail não encontrado para este cargo.'])
                ->onlyInput('role', 'email');
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors(['password' => 'Senha incorreta.'])
                ->onlyInput('role', 'email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function usuariosPorCargo(Request $request)
    {
        $role = $request->query('role');
        if (!$role) return response()->json([]);
        $usuarios = User::where('role', $role)->where('ativo', true)
            ->select('id', 'name')->get();
        return response()->json($usuarios);
    }
}
