<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="{{ URL::to('/') }}/icons/men (1).png">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{URL::to('/')}}/css/boostrap_admin.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #E4E9F7;
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-form {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-custom {
            background-color: #11101D;
            border-color: #11101D;
            border-radius: 20px;
            padding: 10px 20px;
            color: white;
            width: 100%;
        }

        .btn-custom:hover {
            background-color: white;
            border-color: #11101D;
            color: #11101D;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST" action="{{ URL::to('/log') }}">
            @csrf
            <h2>Admin Login</h2>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                <span class="error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <span class="error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <button type="submit" class="btn-custom">Login</button>
        </form>
    </div>
</body>
</html>
