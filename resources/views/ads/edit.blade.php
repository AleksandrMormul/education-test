@extends('layouts.app')

@push('scripts')
    <!-- Google Maps -->
    <script src="https://maps.google.com/maps/api/js?key={{ config('app.google_api_key')}}"></script>
    <script>
        const phoneNumber ='{{ $ad->phone_number }}';
        const lat = {{ $ad->latitude ?: 'null' }};
        const lng = {{ $ad->longitude ?: 'null' }};
    </script>
@endpush

@section('content')
    <form class="create-ad-from" id="adForm" novalidate method="post" action="{{ route('ads.update', $ad->id) }}" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put" />
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="@error('title') is-invalid @enderror form-control" required value="{{ $ad->title }}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="@error('description') is-invalid @enderror form-control" rows="3" required name="description" minlength="100">{{ $ad->description }}</textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="price">Price(UAH)</label>
            <input type="number" step="0.01" min="1" id="adPrice" class="@error('price') is-invalid @enderror form-control" required name="price" value="{{ $ad->price / 100 }}">
            @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="@error('phone_number') is-invalid @enderror form-control" id="adPhone" name="phone_number" required>
            @error('phone_number')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="alert phone-error" style="display: none"></div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="@error('email') is-invalid @enderror form-control" id="adEmail" aria-describedby="emailHelp" required name="email" value="{{ $ad->user->email }}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="endDate">End date</label>
            <input class="@error('end_date') is-invalid @enderror form-control" id="adEndDate" required name="end_date"
                   value="{{ $ad->end_date->format('Y-m-d') }}">
            @error('end_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <div>
            <select type="text" id="adSelectCountry" name="country_code" class="@error('country_code') is-invalid @enderror form-control countrySelect" required>
            @foreach( $countries as $code => $country)
                <option value="{{ $code }}">{{ $country }}</option>
            @endforeach
            </div>
                <script>
                    $('#adSelectCountry').val(@json($ad->country_code));
                </script>
            @error('country_code')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="adFile">Select files for ad</label>
            <input type="file" class="@error('ad_file') is-invalid @enderror form-control-file" id="adFile" name="ad_file"
                   value="{{  Storage::url($ad->img_src) }}">
            @error('ad_file')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="gmap" id="adMap"></div>
        <button type="submit"  id="adBtnSave" class="btn btn-primary btnSubmit">Save</button>
    </form>
@endsection
