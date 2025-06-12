

<!-- 登録バリデーション -->
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
    <select name="season">
        <option value="">選択してください</option>
        <option value="春" {{ old('season') == '春' ? 'selected' : '' }}>春</option>
        <option value="夏" {{ old('season') == '夏' ? 'selected' : '' }}>夏</option>
        <option value="秋" {{ old('season') == '秋' ? 'selected' : '' }}>秋</option>
        <option value="冬" {{ old('season') == '冬' ? 'selected' : '' }}>冬</option>
    </select>
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
</form>