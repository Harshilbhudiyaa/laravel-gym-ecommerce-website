@extends('admin_sidebar')

@section('sidebar')

<style>
    .form-container {
        max-width: 600px;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: auto;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
    }
    .form-control-file {
        overflow: hidden;
    }

    .table-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
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
    .delete-link {
        color: red;
        cursor: pointer;
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

<div class="h1">
    <h1 style="margin-left:30px; text-align:center;">Category</h1>
</div><br>

<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">Add New Category</h2>
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <span class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <button type="submit" class="btn btn-custom">Submit</button>
        </form>
    </div>
</div>

<div class="container"> 
    <div class="table-container">
        <h2 class="table-title">Categories</h2>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->category }}</td>
                            <!-- Update delete link with GET route and confirmation -->
                            <td><a href="{{ route('categories.deleted', $category->id) }}" class="delete-link" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
