@extends('layouts.app')

@section('content')
    <button type="button" class="btn btn btn-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
        </svg>
        <a href="{{ url()->previous() }}">Back</a>
    </button>

    <div class="container-fluid">
        <h2>{{ $ad->title }}</h2>
        <div class="row">
            <div class="col-12 content">
                    <div>
                        <div class="container-img-ad">
                            <img class="ad-image" src="{{$ad->img_src ? asset('storage/'. $ad->user_id .'/'. $ad->img_src) : asset('images/temp.png') }}"
                                alt="ad image">

                        </div>
                        <p>{{ $ad->description }}</p>
                        <p>{{ optional($ad->created_at)->toDateString() }}</p>
                        <p>Email:
                            <span class="contact-text">{{ $ad->user->email }}</span>
                        </p>
                        <p>Phone number:
                            <span class="contact-text">{{ $ad->phone_number ?: 'The user did not set phone number' }}</span>
                        </p>
                        <p>Country:
                            <span class="contact-text">{{ $ad->getFullNameContryAttribute() ?: 'The user did not set country' }}</span>
                        </p>
                        @if( $ad->latitude && $ad->longitude )
                        <iframe style="width:100%; height:220px;overflow:auto;"
                                src="https://www.google.com/maps/embed/v1/place?key={{ config('app.google_api_key')}}&q={{ $ad->latitude }}, {{ $ad->longitude }}"
                                target="_parent" allowfullscreen="allowfullscreen"></iframe>
                        @endif
                    </div>
            </div>
        </div>
    </div>
@endsection
