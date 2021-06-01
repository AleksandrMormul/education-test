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
    @auth
        <a href="{{ route("ads.index", 'favorites=1') }}" class="btn btn-primary show-favorite-btn">Show my favorite ads</a>
    @endauth

    <div class="alert alert-success alert-block deleteInfo" >
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong id="subscriptionMsg"></strong>
    </div>

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block deleteInfo">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <div class="container">
        @if($ads->count() > 0)
            <div class="row">
                @foreach ($ads as $ad)
                    <div class="col-4 content">
                        <div class="card">
                            <div class="container-img-ad">
                                <img src="{{ $ad->image_url }}"
                                     class="card-img-top" alt="ad image">
                                @auth
                                    <i id="heartId-{{$ad->id}}" data-ad-id="{{$ad->id}}" class="heart {{ $ad->isFavorite || $ad->favoriteable_id ? 'fas' : 'far'}}  fa-heart"></i>
                                @endauth
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">{{ $ad->title }}</h3>
                                <p class="card-text">{{ $ad->description }}</p>
                                <p class="card-text">Created at {{ optional($ad->created_at)->toDateString() }}</p>
                                <p class="card-text">End date {{ optional($ad->end_date)->toDateString() }}</p>
                                <a href="{{ route('ads.show', $ad->id) }}" id="adDetail" class="btn btn-primary">Show details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>List of favorite ads are empty</p>
        @endif
    </div>
    <div>
        @auth()
            <form method="GET" id="adSubscription" action="{{ route('ads.index') }}">
                {{ csrf_field() }}
            </form>
            <input type="button" id="adSubscriptionBtn1"
                class="btn {{ request()->user()->subscription ? 'unSubscriptionBtn' : 'subscriptionBtn'}}"
                onclick="confirmSubscription()" name="sbs" value="{{ request()->user()->subscription ? 'Unsubscribe' : 'Subscribe' }}">
        @endauth
    </div>
    <div class="d-flex justify-content-center">
        {!! $ads->links() !!}
    </div>
@endsection
