<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Season;

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
            $sortLabel = '低い順に表示';
        } elseif ($sort === 'desc') {
            $sortLabel = '高い順に表示';
        }
    
        return view('index', compact('products', 'keyword', 'sort', 'sortLabel'));
    }

    // 登録フォーム表示
    public function create()
    {
        // seasons テーブルの全件取得（id, name）
        $seasons = Season::all(); 
        return view('create', compact('seasons'));
    }

    // 登録処理
    public function store(StoreProductRequest $request)
    {
        $path = $request->file('image')->store('images', 'public');

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path,
        ]);
        // 選ばれた季節を中間テーブルに保存
        $product->seasons()->attach($request->season);

        return redirect()->route('products.index');
    }

    // 詳細画面
    public function show($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();
        return view('show', compact('product', 'seasons'));  // Blade内に編集フォームを含める
    }
    // 詳細画面の更新処理
    public function update(UpdateProductRequest $request, $productId)
    {
    $product = Product::findOrFail($productId);

    $product->seasons()->sync($request->season);

    if ($request->hasFile('image')) {
        // 古い画像を削除
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }
        // 新しい画像を保存
        $path = $request->file('image')->store('images', 'public');
        $product->image = $path;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

    return redirect()->route('products.index', $productId);
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