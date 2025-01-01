@extends('admin_sidebar')
@section('sidebar')

<h1 style="text-align:center">Offers</h1>
<style>
    /* Simplified form and dropdown styles */
    .form-container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: bold;
    }
    .form-control {
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control:focus {
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        border-color: #80bdff;
    }
    .btn-custom {
        background-color: #11101D;
        border-color: #11101D;
        border-radius: 20px;
        padding: 10px 20px;
        color: white;
    }
    .btn-custom:hover {
        background-color: white;
        border-color: #11101D;
        color: #11101D;
    }
</style>

<div class="container form-container">
    <form action="{{ route('apply.offer') }}" method="POST">
        @csrf

        <!-- Category Dropdown -->
        <div class="form-group">
            <label for="category" class="form-label">Select Category</label>
            <select class="form-control" id="category" name="category">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>

        <!-- Offer Percentage Dropdown -->
        <div class="form-group">
            <label for="offerPercentage" class="form-label">Offer Percentage</label>
            <select class="form-control" id="offerPercentage" name="offerPercentage">
                <option value="0">0%</option>
                <option value="10">10%</option>
                <option value="20">20%</option>
                <option value="30">30%</option>
                <option value="40">40%</option>
                <option value="50">50%</option>
                <option value="60">60%</option>
                <option value="70">70%</option>
                <option value="80">80%</option>
                <option value="90">90%</option>
                <option value="100">100%</option>
            </select>
        </div>

        <button type="submit" class="btn btn-custom">Submit</button>
    </form>
</div>

@endsection
