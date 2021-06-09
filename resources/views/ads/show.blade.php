@extends('layouts.app')
@push('scripts')
        <script>
            function confirmDelete()
            {
                const result = confirm('Are you sure you want to delete this ad?');
                if(result){
                    event.preventDefault();
                    document.getElementById('delete-ad').submit();
                }
            }
        </script>
        <script>
            $(function(){
                window.setTimeout(function(){
                    $('.alert-danger').alert('close');
                },5000);
            });
        </script>
@endpush
@section('content')
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block deleteInfo">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <button type="button" class="btn btn btn-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
        </svg>
        <a href="{{ url()->previous() }}">Back</a>
    </button>
    @can('update', $ad)
     <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-link btn-edit-ad">Edit</a>
    @endcan

    <div class="container-fluid">
        <h2>{{ $ad->title }}</h2>
        <div class="row">
            <div class="col-12 content">
                    <div>
                        <div class="container-img-ad">
                            <img class="ad-image" src="{{ $ad->image_url }}" alt="ad image">
                            @auth
                                <i id="heartId-{{$ad->id}}" data-ad-id="{{$ad->id}}" class="heart  {{ $isFavorite ? 'fas' : 'far'}}  fa-heart"></i>
                            @endauth
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
                            <span class="contact-text">{{ $ad->full_name_country ?: 'The user did not set country' }}</span>
                        </p>
                        <p class="card-text">Price:</p>
                        <p class="card-text">EURO: <span class="adPrice">{{$ad->price_currency_e_u_r}}</span></p>
                        <p class="card-text">USD: <span class="adPrice">{{$ad->price_currency_u_s_d}}</span></p>
                        <p class="card-text">UAH: <span class="adPrice">{{$ad->price_currency_u_a_h}}</span></p>
                        @if( $ad->latitude && $ad->longitude )
                        <iframe style="width:100%; height:220px;overflow:auto;"
                                src="https://www.google.com/maps/embed/v1/place?key={{ config('app.google_api_key')}}&q={{ $ad->latitude }}, {{ $ad->longitude }}"
                                target="_parent" allowfullscreen="allowfullscreen"></iframe>
                        @endif
                    </div>
            </div>
        </div>
        <div>
            <a id="payPal" data-ad-id="{{$ad->id}}" data-ad-price="{{$ad->price_currency_u_s_d}}" class="btn btn-primary">Pay by PayPal</a>
        </div>
        @can('delete', $ad)
            <form method="POST" id="delete-ad" action="{{ route('ads.destroy', $ad->id) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
            </form>
            <button onclick="confirmDelete()" class="btn btn-delete-ad">Delete</button>
        @endcan
    </div>
@endsection
