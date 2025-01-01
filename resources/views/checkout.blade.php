@extends('layouts.app')

@section('content')
<br>
<br><br>
<div class="checkout-container">
    <h1 class="checkout-title">Checkout</h1>

    <div class="container">
        <div class="row">
            
            <div class="col-md-8">
                <div class="checkout-form">
                    <h2>Shipping Information</h2>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form id="checkout-form" action="{{ URL::to('/') }}/checkout" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Shipping Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" placeholder="Enter your shipping address">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="city">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" placeholder="Enter your city">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="state">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}" placeholder="Enter your state">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for="zip">Pin Code</label>
                                <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip" value="{{ old('zip') }}" placeholder="Enter pin code">
                                @error('zip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" id="place-order-btn">Place Order</button>
                    </form>
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="col-md-4">
                <div class="order-summary">
                    <h2>Order Total</h2>
                    <div class="order-total">
                        @if($totalPrice > 0)
                            <h3>Total Price: ₹{{ number_format($totalPrice, 2) }}</h3>
                        @else
                            <p>No items in the cart.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  

<style>
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    .checkout-title {
        text-align: center;
        margin-bottom: 40px;
        color: #333;
        font-size: 2.5rem;
    }
    .checkout-form, .order-summary {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        padding: 30px;
        margin-bottom: 30px;
    }
    .checkout-form h2, .order-summary h2 {
        margin-bottom: 20px;
        color: #333;
        font-size: 1.8rem;
    }
    .form-control {
        border-radius: 4px;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 12px;
        font-size: 1.1rem;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .order-total {
        margin-top: 20px;
        text-align: center;
    }
    .order-total h3 {
        font-size: 1.6rem;
        color: #28a745;
    }
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.querySelector('#checkout-form').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = document.getElementById('checkout-form');
        var formData = new FormData(form);

        var options = {
            "key": "rzp_test_GDMFMRAC3bnneR", 
            "amount": {{ $totalPrice * 100 }}, 
            "currency": "INR",
            "name": "FITNESS",
            "description": "Transaction",
            "handler": function (response){
                alert(response.razorpay_payment_id);
                form.submit();
            },
            "prefill": {
                "name": formData.get('name'),
                "email": "customer@example.com",
                "contact": "9999999999"
            },
            "notes": {
                "address": formData.get('address')
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    });
</script>

@endsection
