@extends('layouts.app')

@section('content')
    <!-- Google Maps -->
    <script src="https://maps.google.com/maps/api/js?key={{ config('app.google_api_key')}}"></script>
    <div>
        <form class="create-ad-from" id="adForm" novalidate method="post" action="{{ route('ads.store') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="@error('title') is-invalid @enderror form-control" required>
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="valid-feedback"/>
                <div class="invalid-feedback">
                    This field is required!
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="@error('description') is-invalid @enderror form-control" rows="3" required name="description" minlength="100"></textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="valid-feedback"/>
                <div class="invalid-feedback">
                    This field is required! Minimum length 100
                </div>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="@error('phone') is-invalid @enderror  form-control" id="adPhone" name="phone" required>
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="alert phone-error" style="display: none"></div>
                <div class="valid-feedback"/>
                <div class="invalid-feedback">
                    This field is required!
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="@error('email') is-invalid @enderror form-control" id="adEmail" aria-describedby="emailHelp" required name="email">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <small id="adEmailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
                <div class="valid-feedback"/>
                <div class="invalid-feedback">
                    This field is required!
                </div>
            </div>
            <div class="form-group">
                <label for="endDate">End date</label>
                <input type="date" class="@error('endDate') is-invalid @enderror form-control" id="adEndDate" required name="endDate"
                       min="{{ Carbon\Carbon::today()->toDateString()}}">
                @error('endDate')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="valid-feedback"/>
                <div class="invalid-feedback">
                    This field is required!
                </div>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" name="country" class="@error('country') is-invalid @enderror form-control" required>
                @error('country')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">
                    This field is required!
                </div>
            </div>
            <div class="form-group">
                <label for="adFile">Select files for ad</label>
                <input type="file" class="form-control-file" id="adFile" name="adFile">
            </div>
            <div class="gmap" id="adMap"></div>
            <button type="submit" id="adBtnSubmit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
