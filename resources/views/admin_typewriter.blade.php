@extends('admin_sidebar')
@section('sidebar')

<h1 style="text-align:center">Dynamic Typewriter</h1>

<style>
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

<div class="form-container">
    <form action="{{ route('admin.typewriter.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="typewriter_text" class="form-label">Add New Typewriter Text</label>
            <input type="text" class="form-control" id="typewriter_text" name="typewriter_text" required>
        </div>
        <button type="submit" class="btn btn-custom">Add Text</button>
    </form>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Typewriter Text</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($typewriterTexts as $string)
            <tr>
                <td>{{ $string->id }}</td>
                <td>{{ $string->text }}</td>
                <td>
                    <!-- Removed the delete form as the route is not defined -->
                    <button class="btn btn-danger btn-sm" onclick="alert('Delete functionality not implemented yet.')">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    .table-container {
        margin-top: 30px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    .table tr:hover {
        background-color: #f5f5f5;
    }
    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
</style>


@endsection
