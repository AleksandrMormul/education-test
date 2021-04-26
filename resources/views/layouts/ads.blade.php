@extends('layouts.app')

@section('ads-content')

    @foreach ($ads as $ad)
        <div class="col-4 content">
            <div class="card">
                <img src="{{ $ad->image ?? 'https://img.lovepik.com/element/40030/1478.png_860.png' }}"
                    class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $ad->title }}</h5>
                    <p class="card-text">{{ $ad->description }}</p>
                    <p class="card-text">{{ date('d-m-Y', strtotime($ad->created_at)) }}</p>
                    <a href="{{'/'.$ad->id}}" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-center">
        {!! $ads->links() !!}
    </div>
@endsection
