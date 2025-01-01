@extends('admin_sidebar')

@section('sidebar')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Cards</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-custom {
            background-color: #003366;
            color: white;
            transition: transform 0.3s;
            border-radius: 10%; /* Add border-radius */
        }
        .card-custom:hover {
            transform: scale(1.05);
        }
        .card-height {
            min-height: 170px; /* Adjust the height as needed */
            min-width: 250px;
        }
        .card-title {
            text-align: center;
            top: 2%;
        }
    </style>
</head>
<body>
    <h1 style="margin-left:30px; text-align:center">Dashboard</h1>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <a href="{{URL::to('/')}}/admin_About" style="text-decoration: none; color: white;">
                    <div class="card card-custom mb-4 card-height">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title text-center">About us</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- <div class="col-md-3">
                <a href="{{URL::to('/')}}/admin_typewriter" style="text-decoration: none; color: white;">
                    <div class="card card-custom mb-4 card-height">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title text-center">Dynamic Typewriter</h5>
                        </div>
                    </div>
                </a>
            </div> -->



            <div class="col-md-3">
                <a href="{{URL::to('/')}}/admin_service" style="text-decoration: none; color: white;">
                    <div class="card card-custom mb-4 card-height">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title text-center">Services</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{URL::to('/')}}/admin_trainer" style="text-decoration: none; color: white;">
                    <div class="card card-custom mb-4 card-height">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title text-center">Trainers</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{URL::to('/')}}/admin_slider" style="text-decoration: none; color: white;">
                    <div class="card card-custom mb-4 card-height">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title text-center">Slider</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{URL::to('/')}}/admin_category" style="text-decoration: none; color: white;">
                    <div class="card card-custom mb-4 card-height">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title text-center">category</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

@endsection
