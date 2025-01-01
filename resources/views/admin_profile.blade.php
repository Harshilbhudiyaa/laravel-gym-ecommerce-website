@extends('admin_sidebar')

@section('sidebar')

<h1 style="margin-left:30px; text-align:center;">Admin Profile</h1>

<style>
    body {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        font-family: 'Arial', sans-serif;
    }
    .profile-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 100px);
        padding: 20px;
    }
    .profile-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
        text-align: center;
        overflow: hidden;
        transition: transform 0.3s ease;
        padding-top: 80px;
        min-height: 350px;
    }
    .profile-card:hover {
        transform: translateY(-10px);
    }
    .profile-img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        margin-top: -65px;
        transition: transform 0.3s ease;
    }
    .profile-card:hover .profile-img {
        transform: scale(1.1);
    }
    .profile-info {
        padding: 20px;
    }
    .profile-name {
        font-size: 1.8em;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }
    .profile-role {
        font-size: 1em;
        color: #777;
        margin-bottom: 15px;
    }
    @media (max-width: 576px) {
        .profile-card {
            padding: 15px;
            min-height: 300px;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            margin-top: -50px;
        }
    }
    .btn-custom {
        background-color: #11101D;
        border-color: #11101D;
        border-radius: 20px;
        padding: 10px 20px;
        color: white;
        width: 100%;
        margin-bottom: 10px;
    }
    .btn-custom:hover {
        background-color: white;
        color: #11101D;
    }
    .btn-custom-secondary {
        background-color: #6a11cb;
        border-color: #6a11cb;
        border-radius: 20px;
        padding: 10px 20px;
        color: white;
        width: 100%;
    }
    .btn-custom-secondary:hover {
        background-color: #2575fc;
        color: white;
    }
</style>

<div class="profile-container">
    <div class="profile-card">
        <img src="{{ asset('img/admin_profiles/' . $admin->profile) }}" alt="profileImg" class="profile-img">
        <div class="profile-info">
            <div class="profile-name">{{ $admin->name }}</div>
            <div class="profile-role">ADMIN</div>
            <a href="{{ url('/admin_edit_profile') }}" class="btn btn-custom">Edit Profile</a>
            <a href="{{ url('/admin_add_new') }}" class="btn btn-custom">Add New Admin</a>
        </div>
    </div>
</div>

@endsection
