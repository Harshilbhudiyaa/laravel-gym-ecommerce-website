@extends('admin_sidebar')
@section('sidebar')

<h1 style="text-align:center">Orders</h1>
<style>
    /* Simplified modal and table styles */
    .table-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow-x: auto; /* Ensure horizontal scroll on smaller screens */
    }
    .table-title {
        text-align: center;
        margin-bottom: 20px;
    }
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }
    .table-custom th, .table-custom td {
        border: 1px solid #dee2e6;
        padding: 12px;
        text-align: center;
    }
    .table-custom th {
        background-color: #343a40;
        color: white;
    }
    .table-custom tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .edit-link {
        color: green;
        cursor: pointer;
    }
    .edit-link:hover {
        color: #11101D;
    }
    .delete-link {
        color: red;
    }
    .form-select {
        width: 100%;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        appearance: none;
    }
    .form-select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .form-select::-ms-expand {
        display: none;
    }
    .form-select option:hover {
        background-color: #11101D;
        color: white;
    }
</style>

<div class="container table-container">
    <table class="table table-custom">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">city</th>
                <th scope="col">state</th>
                <th scope="col">zip</th>
                <th scope="col">Price</th>
                
              
               
                <th scope="col">Order Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->city }}</td>
                <td>{{ $order->state }}</td>
                <td>{{ $order->zip }}</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
               
               
                <td>
                    <form action="{{ route('order.update') }}" method="POST" id="statusForm-{{ $order->id }}">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="waiting" {{ $order->status == 'waiting' ? 'selected' : '' }}>Waiting</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </form>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

</div>

@endsection
