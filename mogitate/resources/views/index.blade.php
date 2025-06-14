<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mogitate</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />

</head>

<body>
    <header class="header">
        <div class="header-logo">
            mogitate
        </div>
    </header>

  <main>
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
            <input class="search-form-eria" type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">

            <label class="select-title" for="sort">価格順で表示</label>                    
            <select class="select-eria" name="sort" id="sort">
                <option class="select-eria-1" value="">価格で並べ替え</option>
                <option class="select-eria-2" value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>低い順に表示</option>
                <option class="select-eria-3" value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
            </select>

            <button class="search-form-button" type="submit">検索</button>
        </form>

            <!-- タグ表示とリセットボタン -->
            @if($sortLabel ?? false)
                <div class="sort-tag">
                    <span class="sort-tag-span">{{ $sortLabel }}</span>
                    <a class="sort-tag-a" href="{{ route('products.index') }}">×</a>
                </div>
            @endif

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
  </main>
</body>
</html>