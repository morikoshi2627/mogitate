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
        <div class="create-page-header">
            <h2>商品登録</h2>
        </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label>商品名:</label>
                <input type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <div style="color: red;">{{ $message }}</div>
                @enderror

                <label>値段:</label>
                    <input type="number" name="price" value="{{ old('price') }}">
                @error('price')
                    <div style="color: red;">{{ $message }}</div>
                @enderror

                <label>季節:</label>
                @php
                    $seasons = ['春', '夏', '秋', '冬'];
                    $selectedSeasons = old('season', []);
                @endphp

                @foreach($seasons as $season)
                    <label>
                        <input
                            type="checkbox"
                            name="season[]"
                            value="{{ $season }}"
                            {{ in_array($season, $selectedSeasons) ? 'checked' : '' }}
                        >
                        {{ $season }}
                    </label>
                @endforeach

                @error('season')
                    <div style="color: red;">{{ $message }}</div>
                @enderror

                <label>商品説明:</label>
                     <textarea name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div style="color: red;">{{ $message }}</div>
                @enderror

                <label>商品画像:</label>
                    <input type="file" name="image">
                @error('image')
                    <div style="color: red;">{{ $message }}</div>
                @enderror

                <button type="submit">登録</button>
                <a class="back-button" href="{{ route('products.index') }}">戻る</a>
            </form>


    </div>
  </main>
</body>
</html>