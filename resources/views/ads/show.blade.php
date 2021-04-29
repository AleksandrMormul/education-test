@extends('layouts.app')

@section('content')
    <button type="button" class="btn btn btn-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
        </svg>
        <a href="{{ url("/ads") }}">Back</a>
    </button>

    <div class="container">
        <div class="row">
            <div class="col-4 content">
                <div class="card">
                    <img src="{{ $ad->image_src ?? asset('images/temp.png') }}"
                         class="card-img-top" alt="ad image">
                    <div class="card-body">
                        <h3 class="card-title">{{ $ad->title }}</h3>
                        <p class="card-text">{{ $ad->description }}</p>
                        <p class="card-text">{{ optional($ad->created_at)->toDateString() }}</p>
                        <span class="card-text">Email:
                            <p class="contact-text">{{ $user->email }}</p>
                        </span>
                        <span class="card-text">Phone number:
                            <p class="contact-text">{{ $user->phone_number ?: 'The user did not set phone number' }}</p>
                        </span>
                        <span class="card-text">Country:
                            <p class="contact-text">{{ $ad->country ?: 'The user did not set country' }}</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="map-container">
        <iframe style="width:50%; height:220px;overflow:auto; margin-left: 300px"
            src="https://www.google.com/maps/embed/v1/place?key={{ config('app.google_maps')}}&q=47.82863334720865, 35.08344612555284"
            target="_parent" allowfullscreen="allowfullscreen"></iframe>
    </div>
@endsection
