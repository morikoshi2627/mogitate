@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />

@endsection


@section('content')

    <div class="product-page">
         <div class="product-page-header">
            @if(request('keyword'))
              <h2>"{{ request('keyword') }}"の商品一覧</h2>
            @else
              <h2>商品一覧</h2>
            @endif
              <a class="add-button" href="{{ route('products.create') }}">＋商品を追加</a>
         </div>
       <div class="product-page-main">
          <!-- 検索 + 並び替え統合フォーム -->
          <form class="search-form" action="{{ route('products.search') }}" method="GET">
             <input class="search-form-area" type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
             <button class="search-form-button" type="submit">検索</button>

             <label class="select-title" for="sort">価格順で表示</label>                    
             <select class="select-area" name="sort" id="sort">
                <option value="">価格で並べ替え</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>低い順に表示</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
             </select>
          <!-- タグ表示とリセットボタン -->
            @if($sortLabel ?? false)
              <div class="sort-tag">
                  <span class="sort-tag-span">{{ $sortLabel }}</span>
                  <a class="sort-tag-a" href="{{ route('products.index') }}">×</a>
              </div>
            @endif
          </form>
          <!-- 商品表示 -->
              <div class="product-grid">
                @foreach($products as $product)
                  <div class="product-card">
                    <a class="product-link" href="{{ route('products.show', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="product-info">
                      <span class="product-name">{{ $product->name }}</span>
                      <span class="product-price">¥{{ number_format($product->price) }}</span>
                    </div>
                    </a>
                  </div>
                  @endforeach
              </div>
       </div>

            <!-- ページネーション -->
            <div class="pagination">
              @foreach (range(1, $products->lastPage()) as $page)
                @if ($page == $products->currentPage())
                   <span class="pagination-span">{{ $page }}</span>
                @else
                   <a class="pagination-a" href="{{ $products->url($page) }}">{{ $page }}</a>
                @endif
              @endforeach
            </div>
    </div>
@endsection