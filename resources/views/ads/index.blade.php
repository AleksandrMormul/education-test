@extends('layouts.app')
@push('scripts')
    <script>
        $(function(){
            window.setTimeout(function(){
                $('.alert-success').alert('close');
            },5000);
        });
    </script>
@endpush
@section('content')
    @can('create', \App\Models\Ad::class)
        <a href="{{ route("ads.create") }}" class="btn btn-primary create-ad-btn">Create Ad</a>
    @endcan
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block deleteInfo" >
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <div class="container">
        <div class="row">
            @foreach ($ads as $ad)
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
        {!! $ads->links() !!}
    </div>
@endsection
