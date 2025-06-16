<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mogitate</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/create.css') }}" />

</head>

<body>
    <header class="header">
        <div class="header-logo">
            mogitate
        </div>
    </header>

  <main>
    <div class="create-page">
      <div class="create-page-inner">  
         <div class="create-page-header">
            <h2>商品登録</h2>
         </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
              <div class="form-group">
                 <div class="form-labels">
                  <label>商品名</label>
                  <label class="required">必須</label>
                 </div>
                 <input class="product-name-area" type="text" name="name" placeholder="商品名を入力" value="{{ old('name') }}">
                @error('name')
                  <div class="error">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                  <div class="form-labels">
                    <label>値段</label>
                    <label class="required">必須</label>
                  </div>
                  <input class="price-area" type="number" name="price" placeholder="値段を入力" value="{{ old('price') }}">
                @error('price')
                  <div class="error">{{ $message }}</div>
                @enderror
               </div>

              <div class="form-group">
                  <div class="form-labels">
                    <label>商品画像</label>
                    <label class="required">必須</label>
                  </div>
                  <input class="image-area" type="file" name="image">
                @error('image')
                  <div class="error">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <div class="form-labels">
                    <label>季節</label>
                    <label class="required">必須</label>
                    <label class="selection-label">複数選択可</label>
                </div>
                <div class="season-checkboxes">
                 @php
                    $selectedSeasons = old('season', []);
                 @endphp
                 @foreach($seasons as $season)
                    <label class="checkbox-label">
                        <input class="checkbox-label-input"
                            type="checkbox"
                            name="season[]"
                            value="{{ $season->id }}"
                            {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}
                        >
                        <span class="custom-checkbox"></span>
                        {{ $season->name }}
                    </label>
                 @endforeach
                </div>
                @error('season')
                  <div class="error">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                  <div class="form-labels">
                    <label>商品説明</label>
                    <label class="required">必須</label>
                  </div>
                  <textarea class="description-area"  name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                 @error('description')
                   <div class="error">{{ $message }}</div>
                 @enderror
              </div>

              <div class="button-area">
                <a class="back-button" href="{{ route('products.index') }}">戻る</a>
                <button class="register-button" type="submit">登録</button>
              </div>
            </form>
      </div>
    </div>
  </main>
</body>
</html>