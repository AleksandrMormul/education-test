@extends('layouts.app')

@section('content')
    @if( count($favoritesAds) > 0 )
    <div class="container">
        <div class="row">
            @foreach ($favoritesAds as $ad)
                <div class="col-4 content">
                    <div class="card">
                        <img src="{{ $ad->image_url }}"
                             class="card-img-top" alt="ad image">
                        <div class="card-body">
                            <h3 class="card-title">{{ $ad->title }}</h3>
                            <p class="card-text">{{ $ad->description }}</p>
                            <p class="card-text">Created at {{ optional($ad->created_at)->toDateString() }}</p>
                            <p class="card-text">End date {{ optional($ad->end_date)->toDateString() }}</p>
                            <a href="{{ route('ads.show', $ad->id) }}" class="btn btn-primary">Show details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {!! $favoritesAds->links() !!}
    </div>
    @else
        <div class="container">
            <p>List of favorite ads are empty</p>
        </div>
    @endif
@endsection
