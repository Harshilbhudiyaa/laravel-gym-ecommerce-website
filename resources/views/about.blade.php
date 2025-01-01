@extends('layouts.app')

@section('content')

<div class="main_contact">
    <div class="txt_contact">
        <h1>ABOUT</h1>
    </div>
</div>

<br><br>

<div class="container-fluid main_about">
    <div class="row">
        <div class="col-md-6 about_img">
            <img src="{{URL::to('/')}}/img/about/{{ $image->img }}" alt="Gym Image">
        </div>
        <div class="col-md-6 about_text">
            <h2 style="font-weight:bolder;" class="text-primary">About Us</h2>
            @forelse($data as $about)
                <p>{{ $about->description }}</p>
            @empty
                <p>No description available.</p>
            @endforelse

            {{-- <p>We are dedicated to creating a supportive and motivational environment for all our members. Whether you
                are a beginner or a seasoned athlete, our certified trainers and friendly staff are here to guide you
                every step of the way.</p>
            <p>Join us today and take the first step towards a healthier, happier you!</p> --}}

            <div class="progress-section">
                <div class="progress-label">Fit Persons: 75%</div>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
                <div class="progress-label mt-4">People Trained: 80%</div>
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%;" aria-valuenow="90"
                        aria-valuemin="0" aria-valuemax="100">80%</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
