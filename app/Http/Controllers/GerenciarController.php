<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\MenuItem;
use App\Models\Category;
use App\Models\StockItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568

class GerenciarController extends Controller
{
    private function soGerente()
    {
<<<<<<< HEAD
        if (Auth::user()?->role !== 'gerente') abort(403);
=======
        if (Auth::user()->role !== 'gerente') abort(403);
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    }

    public function mesas()
    {
        $this->soGerente();
        $mesas = Table::orderBy('numero')->get();
        return view('gerenciar.mesas', compact('mesas'));
    }

    public function cardapio()
    {
        $this->soGerente();
<<<<<<< HEAD
        $itens      = MenuItem::with('category','stockItem')
            ->whereNull('arquivado_em')
            ->orderBy('category_id')
            ->get();
=======
        $itens      = MenuItem::with('category','stockItem')->orderBy('category_id')->get();
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        $categorias = Category::orderBy('nome')->get();
        $estoque    = StockItem::orderBy('nome')->get();
        return view('gerenciar.cardapio', compact('itens','categorias','estoque'));
    }

<<<<<<< HEAD
    public function imagemCardapio(string $arquivo)
    {
        abort_if(str_contains($arquivo, '/') || str_contains($arquivo, '\\'), 404);

        $item = MenuItem::whereIn('imagem', ['cardapio/' . $arquivo, 'uploads/cardapio/' . $arquivo])->first();
        if ($item?->imagem_dados) {
            return response(base64_decode($item->imagem_dados), 200, [
                'Content-Type' => $item->imagem_mime ?: 'image/jpeg',
                'Cache-Control' => 'public, max-age=604800',
            ]);
        }

        $storagePath = storage_path('app/public/cardapio/' . $arquivo);
        if (File::exists($storagePath)) {
            return response()->file($storagePath);
        }

        $legacyPath = public_path('uploads/cardapio/' . $arquivo);
        if (File::exists($legacyPath)) {
            return response()->file($legacyPath);
        }

        abort(404);
    }

=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    public function cardapioStore(Request $request)
    {
        $this->soGerente();
        $v = $request->validate([
            'nome'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'preco'         => 'required|numeric|min:0.01',
            'descricao'     => 'nullable|string|max:500',
<<<<<<< HEAD
            'imagem'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            'stock_item_id' => 'nullable|exists:stock_items,id',
            'disponivel'    => 'nullable|boolean',
            'serves_count'  => 'required|integer|min:1|max:50',
            'subtipo'       => 'nullable|string|max:100',
        ]);
<<<<<<< HEAD
        if ($request->hasFile('imagem')) {
            $v = array_merge($v, $this->salvarImagemCardapio($request));
        }
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        $v['disponivel'] = $request->has('disponivel');
        MenuItem::create($v);
        return back()->with('success', '✅ Item adicionado ao cardápio!');
    }

    public function cardapioUpdate(Request $request, MenuItem $item)
    {
        $this->soGerente();
        $v = $request->validate([
            'nome'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'preco'         => 'required|numeric|min:0.01',
            'descricao'     => 'nullable|string|max:500',
<<<<<<< HEAD
            'imagem'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
            'stock_item_id' => 'nullable|exists:stock_items,id',
            'disponivel'    => 'nullable|boolean',
            'serves_count'  => 'required|integer|min:1|max:50',
            'subtipo'       => 'nullable|string|max:100',
        ]);
<<<<<<< HEAD
        if ($request->hasFile('imagem')) {
            $this->removerImagemCardapio($item->imagem);
            $v = array_merge($v, $this->salvarImagemCardapio($request));
        }
=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        $v['disponivel'] = $request->has('disponivel');
        $item->update($v);
        return back()->with('success', '✅ Item atualizado!');
    }

<<<<<<< HEAD
    public function cardapioImagem(Request $request, MenuItem $item)
    {
        $this->soGerente();
        $request->validate([
            'imagem' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $this->removerImagemCardapio($item->imagem);
        $item->update($this->salvarImagemCardapio($request));

        return back()->with('success', 'Foto do prato atualizada!');
    }

    public function cardapioDestroy(MenuItem $item)
    {
        $this->soGerente();

        if ($item->orderItems()->exists()) {
            $item->update([
                'disponivel' => false,
                'arquivado_em' => now(),
            ]);

            return back()->with('success', 'Item removido do cardapio. O historico de pedidos foi preservado.');
        }

        $this->removerImagemCardapio($item->imagem);
=======
    public function cardapioDestroy(MenuItem $item)
    {
        $this->soGerente();
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        $item->delete();
        return back()->with('success', '✅ Item removido do cardápio!');
    }

<<<<<<< HEAD
    private function salvarImagemCardapio(Request $request): array
    {
        $arquivo = $request->file('imagem');
        $nome = uniqid('prato_', true).'.'.$arquivo->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('cardapio', $arquivo, $nome);

        return [
            'imagem' => 'cardapio/'.$nome,
            'imagem_dados' => base64_encode(File::get($arquivo->getRealPath())),
            'imagem_mime' => $arquivo->getMimeType(),
        ];
    }

    private function removerImagemCardapio(?string $imagem): void
    {
        if (!$imagem) {
            return;
        }

        if (str_starts_with($imagem, 'cardapio/')) {
            Storage::disk('public')->delete($imagem);
            return;
        }

        if (str_starts_with($imagem, 'uploads/cardapio/')) {
            $path = public_path($imagem);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }

=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    public function funcionarios()
    {
        $this->soGerente();
        $usuarios = User::orderBy('role')->orderBy('name')->get();
        return view('gerenciar.funcionarios', compact('usuarios'));
    }

    public function produtos()
    {
        $this->soGerente();
        $itens = StockItem::orderBy('nome')->get();
        return view('gerenciar.produtos', compact('itens'));
    }

    public function produtosStore(Request $request)
    {
        $this->soGerente();
        $v = $request->validate([
            'nome'             => 'required|string|max:255',
            'unidade'          => 'required|string|max:20',
            'quantidade_atual' => 'required|numeric|min:0',
            'quantidade_minima'=> 'required|numeric|min:0',
            'preco_unitario'   => 'required|numeric|min:0',
        ]);
        StockItem::create($v);
        return back()->with('success', '✅ Produto cadastrado!');
    }

    public function produtosUpdate(Request $request, StockItem $item)
    {
        $this->soGerente();
        $v = $request->validate([
            'nome'             => 'required|string|max:255',
            'unidade'          => 'required|string|max:20',
            'quantidade_minima'=> 'required|numeric|min:0',
            'preco_unitario'   => 'required|numeric|min:0',
        ]);
        $item->update($v);
        return back()->with('success', '✅ Produto atualizado!');
    }

    public function produtosDestroy(StockItem $item)
    {
        $this->soGerente();
<<<<<<< HEAD

        if ($item->movimentos()->exists() || $item->menuItems()->exists() || $item->ingredientes()->exists()) {
            return back()->with('error', 'Este produto possui historico ou vinculos no cardapio. Ajuste o estoque ou desvincule o item em vez de excluir.');
        }

=======
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
        $item->delete();
        return back()->with('success', '✅ Produto removido!');
    }
}
