@extends('admin_sidebar')
@section('sidebar')

<h1 style="margin-left:30px; text-align:center;">Add New Admin</h1>

<style>
    body {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        font-family: 'Arial', sans-serif;
    }
    .form-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 50px auto;
        max-width: 600px;
    }
    .form-card {
        padding: 40px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        font-weight: bold;
    }
    input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .btn-custom {
        background-color: #11101D;
        border-color: #11101D;
        border-radius: 20px;
        padding: 10px 20px;
        color: white;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .btn-custom:hover {
        background-color: white;
        color: #11101D;
    }
    .table-container {
        margin: 50px auto;
        padding: 20px;
        border-radius: 8px;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 1000px;
    }
    .table th, .table td {
        text-align: center;
    }
    .delete-link {
        color: red;
        cursor: pointer;
    }
    .delete-link:hover {
        text-decoration: underline;
    }
    @media (max-width: 768px) {
        .form-container {
            padding: 15px;
        }
        .form-card {
            padding: 20px;
        }
        .table-container {
            padding: 15px;
        }
    }
</style>



@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-container">
    <div class="form-card">
        <form action="{{ url('/admin_add_new') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" >
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" >
            </div>
            <div class="form-group">
                <label for="profile">Profile Picture</label>
                <input type="file" name="profile" id="profile" accept="image/*" >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" >
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="password_confirmation" id="confirm_password" >
            </div>
            
            </div>
            <button type="submit" class="btn btn-custom">Add Admin</button>
        </form>
    </div>
</div>


<!-- Admin Table -->
<div class="table-container">
    <h2 style="text-align:center;">Admin List</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Profile Picture</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @if ($admin->profile)
                            <img src="{{ URL::to('/') }}/img/admin_profiles/{{ $admin->profile }}" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                        @else
                            <img src="{{ URL::to('/') }}/img/default-profile.png" alt="Default Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-link" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
            </tbody>
        </table>
    </div>
</div>


@endsection
