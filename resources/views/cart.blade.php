@extends('layouts.app')

@section('content')

<div class="cart-container">
  <h1 class="cart-title">Your Shopping Cart</h1>

<style>
    .cart-container {
        width: 80%;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .cart-title {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: #333;
        font-weight: 600;
    }

    .cart-items {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 15px;
    }

    .cart-item {
        width: 100%;
        max-width: 31%;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background-color: #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .cart-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .product-image-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 15px;
    }

    .product-image {
        width: 100%;
        max-width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
    }

    .product-details {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .product-name {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #333;
        font-weight: 500;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 600;
        color: #28a745;
        margin-bottom: 20px;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .quantity-control button {
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.25rem;
        margin: 0 5px;
        transition: background-color 0.3s ease;
    }

    .quantity-control button:hover {
        background-color: #0056b3;
    }

    .quantity {
        font-size: 1.5rem;
        margin: 0 10px;
        font-weight: 600;
    }

    .add-to-cart-button, .remove-from-cart-button {
        background-color: #dc3545;
        color: #fff;
        font-size: 1rem;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        margin-top: 10px;
    }

    .add-to-cart-button:hover {
        background-color: #c82333;
    }

    .remove-from-cart-button {
        background-color: #6c757d;
        margin-top: 5px;
    }

    .remove-from-cart-button:hover {
        background-color: #5a6268;
    }

    .cart-summary {
        text-align: center;
        margin-top: 30px;
    }

    .cart-summary p {
        font-size: 1.25rem;
        font-weight: 500;
        color: #333;
    }

    .checkout-button {
        background-color: #007bff;
        color: #fff;
        font-size: 1.25rem;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
    }

    .checkout-button:hover {
        background-color: #0056b3;
    }
</style>

<div class="row cart-items">
    @foreach($products as $product)
    <div class="cart-item col-md-4"> 
        <div class="product-image-wrapper">
            <img src="{{ URL::to('/') }}/img/products/{{ $product->image }}" alt="Product Image" class="product-image">
        </div>
        <div class="product-details">
            <h3 class="product-name">{{ $product->name }}</h3>
            <h6>${{ $product->price }}/per item</h6>
            <p class="product-price" data-original-price="{{ $product->price }}">
                @foreach($cartItems as $cartItem)
                    @if($cartItem->product_id == $product->id)
                        ${{ $product->price * $cartItem->quantity }}
                    @endif
                @endforeach
            </p>
            <div class="quantity-control">
                <button class="btn-decrement" onclick="decrementQuantity(this)">-</button>
                <span class="quantity" id="quantity-{{ $product->id }}">
                    @foreach($cartItems as $cartItem)
                        @if($cartItem->product_id == $product->id)
                            {{ $cartItem->quantity }}
                        @endif
                    @endforeach
                </span>
                <button class="btn-increment" onclick="incrementQuantity(this)">+</button>
            </div>

            <script>
                function decrementQuantity(button) {
                    const quantityElement = button.parentElement.querySelector('.quantity');
                    let quantity = parseInt(quantityElement.textContent);
                    if (quantity > 1) {
                        quantity--;
                        quantityElement.textContent = quantity;

                        button.closest('.product-details').querySelector('input[name="quantity"]').value = quantity;
                    }
                }

                function incrementQuantity(button) {
                    const quantityElement = button.parentElement.querySelector('.quantity');
                    let quantity = parseInt(quantityElement.textContent);
                    quantity++;
                    quantityElement.textContent = quantity;

                  
                    button.closest('.product-details').querySelector('input[name="quantity"]').value = quantity;
                }
            </script>

            <a href="{{ URL::to('/') }}/remove-from-cart/{{ $product->id }}" class="remove-from-cart-button">Remove from Cart</a>
            <form action="{{ URL::to('/') }}/update-cart/{{ $product->id }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="{{ $cartItem->quantity }}">
                <button type="submit" class="remove-from-cart-button">Update Quantity</button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div class="cart-summary">
    <p class="cart-subtotal">Subtotal: <span id="cart-subtotal">${{ $totalPrice }}</span></p>
    
   
    <a href="{{ URL::to('/') }}/checkout?total_price={{ $totalPrice }}">
        <button class="checkout-button">Proceed to Checkout</button>
    </a>
</div>


<br><br>


</div>

@endsection
