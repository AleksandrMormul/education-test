@extends('layouts.app')

@section('content')
    @if(Auth::check())
        <a href="{{ url("/ads/create") }}" class="btn btn-primary create-ad-btn">Create Ad</a>
    @endif
    <div class="container">
        <div class="row">
            @foreach ($ads as $ad)
                <div class="col-4 content">
                    <div class="card">
                        <img src="{{ $ad->image_src ?? asset('images/temp.png') }}"
                            class="card-img-top" alt="ad image">
                        <div class="card-body">
                            <h3 class="card-title">{{ $ad->title }}</h3>
                            <p class="card-text">{{ $ad->description }}</p>
                            <p class="card-text">{{ optional($ad->created_at)->toDateString() }}</p>
                            <a href="{{ url("/ads/$ad->id") }}" class="btn btn-primary">Show details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {!! $ads->links() !!}
    </div>
@endsection
