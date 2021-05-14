@extends('layouts.app')

@section('content')
    <!-- Google Maps -->
    <script src="https://maps.google.com/maps/api/js?key={{ config('app.google_api_key')}}"></script>
    <script>
        const phoneNumber ='{{ $ad->phone_number }}';
        const lat = {{ $ad->latitude }};
        const lng = {{ $ad->longitude }};
        const isEdit = true;
    </script>
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
            <label for="phone">Phone</label>
            <input type="tel" class="@error('phone') is-invalid @enderror form-control" id="adPhone" name="phone" required>
            @error('phone')
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
            <input type="date" class="@error('endDate') is-invalid @enderror form-control" id="adEndDate" required name="endDate" min="{{ Carbon\Carbon::today()->toDateString()}}"
                   value="{{ $ad->end_date->format('Y-m-d') }}">
            @error('endDate')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" name="country" class="@error('country') is-invalid @enderror form-control" required value="{{ $ad->full_name_country }}">
            @error('country')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="adFile">Select files for ad</label>
            <input type="file" class="form-control-file" id="adFile" name="adFile"
                   value="{{  Storage::url($ad->img_src) }}">
        </div>
        <div class="gmap" id="adMap"></div>
        <button type="submit"  id="adBtnSave" class="btn btn-primary">Save</button>
    </form>
@endsection
