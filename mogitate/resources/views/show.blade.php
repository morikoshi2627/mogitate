@extends('layouts.app')

@section('css')

  <link rel="stylesheet" href="{{ asset('css/show.css') }}" />

@endsection

@section('content')

    <div class="show-page">
      <div class="show-page-inner">
            <div class="show-page-header">
             <h2>
                <a class="back-to-index" href="{{ route('products.index') }}">商品一覧</a> > {{ $product->name }}
             </h2>
            </div>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

        <div class="show-content">
         <div class="image-section">
           <!-- 登録済みの画像を表示 -->
           <img class="show-image-preview" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
              <!-- ファイル選択 -->
              <input class="show-image" type="file" name="image">
            @error('image')
              <div style="color: red;">{{ $message }}</div>
            @enderror
         </div>
          <div class="show-details">
            <label class="show-product-name">商品名</label>
              <input class="show-product-name-area" type="text" name="name" value="{{ old('name', $product->name) }}">
            @error('name')
              <div style="color: red;">{{ $message }}</div>
            @enderror

            <label class="show-price">値段</label>
              <input class="show-price-area" type="number" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
              <div style="color: red;">{{ $message }}</div>
            @enderror

            <label class="show-seasons">季節</label>
            @php
            $selectedSeasons = old('season') ?? $product->seasons->pluck('id')->toArray();
            @endphp
            <div class="season-checkboxes">
              @foreach($seasons as $season)
                <label>
                  <input class="checbox-type" type="checkbox" name="season[]" value="{{ $season->id }}" {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}
                  >
                  {{ $season->name }}
                </label>
              @endforeach
            </div>
            @error('season')
            <div style="color: red;">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="show-description">
          <label class="show-description-title">商品説明</label>
            <textarea class="show-description-area" name="description">{{ old('description', $product->description) }}</textarea>
          @error('description')
            <div style="color: red;">{{ $message }}</div>
          @enderror
        </div>
          <div class="button-area">
            <a class="back-button" href="{{ route('products.index') }}">戻る</a>
            <button class="change-button" type="submit">変更を保存</button>
          </div>
        </form>
        <!-- 削除ボタン -->
        <form class="delete-button-area"method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('本当に削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button">
            <img class="trash-icon" src="{{ asset('storage/images/Vector.png') }}" alt="削除">
            </button>
        </form>
      </div>
    </div>
@endsection