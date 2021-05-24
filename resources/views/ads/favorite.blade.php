@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($favorites as $favorite)
                <div class="col-4 content">
                    <div class="card">
                        <img src="{{ $favorite->image_url }}"
                             class="card-img-top" alt="ad image">
                        <div class="card-body">
                            <h3 class="card-title">{{ $favorite->title }}</h3>
                            <p class="card-text">{{ $favorite->description }}</p>
                            <p class="card-text">Created at {{ optional($favorite->created_at)->toDateString() }}</p>
                            <p class="card-text">End date {{ optional($favorite->end_date)->toDateString() }}</p>
                            <a href="{{ route('ads.show', $favorite->id) }}" class="btn btn-primary">Show details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {!! $favorites->links() !!}
    </div>
@endsection
