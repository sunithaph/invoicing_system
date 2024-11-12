@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Product to Cart</h1>

    <form action="{{ route('cart-items.store') }}" method="POST" id="add-to-cart-form">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">Select a Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-stock="{{ $product->quantity }}">
                        {{ $product->name }} - {{ $product->price }} Rs.
                    </option>
                @endforeach
            </select>
            <div id="stock-message" class="text-danger mt-2" style="display: none;"></div>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-success">Add to Cart</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const stockMessage = document.getElementById('stock-message');

    productSelect.addEventListener('change', function () {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock');

        // Check stock availability
        if (stock === "0") {
            stockMessage.textContent = "Item currently not available, try again later.";
            stockMessage.style.display = "block";
            quantityInput.disabled = true;
        } else {
            stockMessage.style.display = "none";
            quantityInput.disabled = false;
            quantityInput.max = stock; // Set max quantity to available stock
            quantityInput.value = 1; // Reset quantity input
        }
    });

    // Validate entered quantity does not exceed available stock
    quantityInput.addEventListener('input', function () {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock');
        
        if (parseInt(quantityInput.value) > parseInt(stock)) {
            alert('Quantity exceeds available stock');
            quantityInput.value = stock; // Set to maximum available stock
        }
    });
});
</script>
@endsection
