<!DOCTYPE html>
<html>
<head>
    <title>Debug Product</title>
</head>
<body>
    <h1>Debug Product ID: 13</h1>
    
    @php
        $product = App\Models\Product::with('sizes')->find(13);
    @endphp
    
    <h2>Product Info:</h2>
    <p>ID: {{ $product->id }}</p>
    <p>Name: {{ $product->name }}</p>
    <p>Sizes Count: {{ $product->sizes->count() }}</p>
    
    <h2>Sizes Data:</h2>
    <ul>
    @foreach($product->sizes as $size)
        <li>Size: {{ $size->size }} - Stock: {{ $size->stock }}</li>
    @endforeach
    </ul>
    
    <h2>Raw Data:</h2>
    <pre>{{ print_r($product->toArray(), true) }}</pre>
</body>
</html>