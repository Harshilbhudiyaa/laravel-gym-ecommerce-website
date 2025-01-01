@extends('layouts.app')

@section('content')
<div class="main_contact">
    <div class="txt_contact">
        <h1>CONTACT</h1>
    </div>
</div>

<div class="container">
    <div class="main_details_contact">
        <div class="symbol_contact">
            <i class="fas fa-map-marker-alt"></i>
            <p>1234 Street Name, City, Country</p>
        </div>
        <div class="symbol_contact">
            <i class="fas fa-phone"></i>
            <p>+123 456 7890</p>
        </div>
        <div class="symbol_contact">
            <i class="fas fa-envelope"></i>
            <p>contact@example.com</p>
        </div>
    </div>

    <div class="main_contact_form">
        @if(session('success'))
            <script>
                alert('{{ session('success') }}');
            </script>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ URL::to('/') }}/contact" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="Enter your message">{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<br><br>
@endsection
