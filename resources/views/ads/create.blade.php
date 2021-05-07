@extends('layouts.app')

@section('content')
    <!-- Google Maps -->
    <script src="http://maps.google.com/maps/api/js?key={{ config('app.google_maps')}}"></script>
    <form class="create-ad-from" id="adForm" novalidate method="post" action="{{ route('ads.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
            <div class="valid-feedback"/>
            <div class="invalid-feedback">
                This field is required!
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" rows="3" required name="description" minlength="100"></textarea>
            <div class="valid-feedback"/>
            <div class="invalid-feedback">
                This field is required! Minimum length 100
            </div>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="number" class="form-control" id="phone" name="phone" required>
            <div class="alert phone-error" style="display: none"></div>
            <div class="valid-feedback"/>
            <div class="invalid-feedback">
                This field is required!
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" required name="email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <div class="valid-feedback"/>
            <div class="invalid-feedback">
                This field is required!
            </div>
        </div>
        <div class="form-group">
            <label for="endDate">End date</label>
            <input type="date" class="form-control" id="endDate" required name="endDate" min="{{ Carbon\Carbon::today()->toDateString()}}">
            <div class="valid-feedback"/>
            <div class="invalid-feedback">
                This field is required!
            </div>
        </div>
        <div class="form-group">
            <label for="adFile">Select files for ad</label>
            <input type="file" class="form-control-file" id="adFile" name="adFile">
        </div>
        <div style=" width: 400px;height: 400px;" id="map"></div>
        <button type="submit"  id="btnSubmit" class="btn btn-primary">Submit</button>
    </form>
@endsection
