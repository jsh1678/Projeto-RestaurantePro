<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Erro 419: CSRF token expirado.
        $exceptions->render(function (
            \Illuminate\Session\TokenMismatchException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sessao expirada. Recarregue a pagina.',
                    'reload'  => true,
                ], 419);
            }
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Sua sessao expirou. Entre novamente para continuar.');
        });

        // Erros 500: excecoes inesperadas.
        $exceptions->render(function (
            \Throwable $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Erro interno do servidor. Tente novamente.',
                ], 500);
            }
            // Para requisicoes normais, deixa o Laravel renderizar errors/500.blade.php.
        });

        // Erros 403: acesso negado.
        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Acesso negado.'], 403);
            }
        });

    })->create();
