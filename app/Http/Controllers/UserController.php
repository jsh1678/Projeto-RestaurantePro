<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()?->role !== 'gerente') abort(403);

        $usuarios = User::orderBy('role')->orderBy('name')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/u'],
            'email'    => ['required','email','unique:users,email'],
            'role'     => 'required|in:garcom,chef,caixa,gerente',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.regex'              => '❌ O nome deve conter apenas letras.',
            'email.unique'            => '❌ Este e-mail já está cadastrado.',
            'email.email'             => '❌ Digite um e-mail válido (ex: nome@dominio.com)',
            'password.min'            => '❌ A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed'      => '❌ As senhas não conferem.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
            'ativo'    => true,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', '✅ Usuário cadastrado com sucesso!');
    }

    public function edit(User $usuario)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/u'],
            'email' => ['required','email','unique:users,email,' . $usuario->id],
            'role'  => 'required|in:garcom,chef,caixa,gerente',
        ], [
            'name.regex'   => '❌ O nome deve conter apenas letras.',
            'email.unique' => '❌ Este e-mail já está cadastrado.',
            'email.email'  => '❌ Digite um e-mail válido (ex: nome@dominio.com)',
        ]);

        if (
            $usuario->role === 'gerente'
            && $validated['role'] !== 'gerente'
            && User::where('role', 'gerente')->count() <= 1
        ) {
            return back()
                ->withInput()
                ->with('error', 'Nao e possivel remover o ultimo gerente do sistema.');
        }

        $usuario->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ]);

        // Atualizar senha só se informada
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ], [
                'password.min'       => '❌ A senha deve ter no mínimo 6 caracteres.',
                'password.confirmed' => '❌ As senhas não conferem.',
            ]);
            $usuario->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('usuarios.index')
            ->with('success', '✅ Usuário atualizado!');
    }

    public function toggleAtivo(User $usuario)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        if ($usuario->id === Auth::id()) {
            return back()->with('error', '❌ Você não pode desativar sua própria conta.');
        }
        if ($usuario->role === 'gerente') {
            return back()->with('error', 'Nao e permitido desativar contas de gerente.');
        }

        $usuario->update(['ativo' => !$usuario->ativo]);
        $status = $usuario->ativo ? 'ativado' : 'desativado';
        return back()->with('success', "✅ Usuário {$status}!");
    }

    public function destroy(User $usuario)
    {
        if (Auth::user()?->role !== 'gerente') abort(403);
        if ($usuario->id === Auth::id()) {
            return back()->with('error', '❌ Você não pode excluir sua própria conta.');
        }
        if ($usuario->role === 'gerente' && User::where('role', 'gerente')->count() <= 1) {
            return back()->with('error', 'Nao e possivel excluir o ultimo gerente do sistema.');
        }

        try {
            DB::transaction(function () use ($usuario) {
                $gerenteAtualId = Auth::id();

                DB::table('tables')
                    ->where('garcom_id', $usuario->id)
                    ->update(['garcom_id' => null]);

                DB::table('stock_movements')
                    ->where('user_id', $usuario->id)
                    ->update(['user_id' => null]);

                DB::table('purchases')
                    ->where('user_id', $usuario->id)
                    ->update(['user_id' => null]);

                DB::table('caixa_fechamentos')
                    ->where('user_id', $usuario->id)
                    ->update(['user_id' => null]);

                DB::table('caixa_fechamentos')
                    ->where('reaberto_por', $usuario->id)
                    ->update(['reaberto_por' => null]);

                DB::table('orders')
                    ->where('user_id', $usuario->id)
                    ->update(['user_id' => $gerenteAtualId]);

                DB::table('sangrias')
                    ->where('user_id', $usuario->id)
                    ->update(['user_id' => $gerenteAtualId]);

                $usuario->delete();
            });
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Nao foi possivel excluir este usuario. Verifique se ele possui registros vinculados.');
        }
        return back()->with('success', '✅ Usuário removido!');
    }
}
