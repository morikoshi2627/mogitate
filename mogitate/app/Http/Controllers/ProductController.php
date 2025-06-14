<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 一覧
    public function index()
    {
        $products = Product::paginate(6);
        return view('index', compact('products'));
    }
    
    // 検索・並び替え（index.blade.phpで表示）
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $sort = $request->input('sort');
    
        $query = Product::query();
    
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    
        if ($sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'desc') {
            $query->orderBy('price', 'desc');
        }
    
        $products = $query->paginate(6)->appends($request->all());
    
        $sortLabel = null;
        if ($sort === 'asc') {
            $sortLabel = '価格：低い順';
        } elseif ($sort === 'desc') {
            $sortLabel = '価格：高い順';
        }
    
        return view('index', compact('products', 'keyword', 'sort', 'sortLabel'));
    }

    // 登録フォーム表示
    public function create()
    {
        return view('create');
    }

    // 登録処理
    public function store(StoreProductRequest $request)
    {
        $path = $request->file('image')->store('images', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'season' => implode(',', $request->season),
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect()->route('products.index');
    }

    // 詳細画面
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('show', compact('product')); // Blade内に編集フォームを含める
    }
    // 詳細画面の更新処理
    public function update(UpdateProductRequest $request, $productId)
    {
    $product = Product::findOrFail($productId);


    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images', 'public');
        $product->image = $path; // 画像保存処理
        }

    $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'season' => implode(',', $request->season),
        'description' => $request->description,
        ]);

    return redirect()->route('products.show', $productId);
    }

    // 削除処理
    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        // 画像ファイルの削除
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index');
    }
}
