@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($ads as $ad)
                <div class="col-4 content">
                    <div class="card">
                        <img src="{{ $ad->image_src ?? asset('storage/images/temp.png') }}"
                            class="card-img-top" alt="ad image">
                        <div class="card-body">
                            <h3 class="card-title">{{ $ad->title }}</h3>
                            <p class="card-text">{{ $ad->description }}</p>
                            <p class="card-text">{{ $ad->created_at->toDateString() }}</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
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
