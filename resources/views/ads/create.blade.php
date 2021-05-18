@extends('layouts.app')

@push('scripts')
    <!-- Google Maps -->
    <script src="https://maps.google.com/maps/api/js?key={{ config('app.google_api_key')}}"></script>
    <script>
        let endDate = new Date('@php echo today()->toDateString() @endphp');
    </script>
@endpush

@section('content')
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
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="@error('description') is-invalid @enderror form-control" rows="3" required name="description" minlength="100"></textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="@error('phone_number') is-invalid @enderror  form-control" id="adPhone" name="phone_number" required>
                @error('phone_number')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="alert phone-error" style="display: none"></div>

            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="@error('email') is-invalid @enderror form-control" id="adEmail" aria-describedby="emailHelp" required name="email">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="endDate">End date</label>
                <input  class="@error('end_date') is-invalid @enderror form-control" id="adEndDate" required name="end_date">
                @error('end_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <div>
                    <select type="text" name="country_code"
                        class="@error('country') is-invalid @enderror form-control countrySelect" required>
                    @foreach( $countries as $code=>$country)
                        <option></option>
                        <option value="{{ $code }}">{{ $country }}</option>
                    @endforeach
                    </select>
                </div>
                @error('country_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="adFile">Select files for ad</label>
                <input type="file" class="@error('ad_file') is-invalid @enderror form-control-file" id="adFile" name="ad_file">
                @error('ad_file')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="gmap" id="adMap"></div>
            <button type="submit" id="adBtnSubmit" class="btn btn-primary btnSubmit">Submit</button>
        </form>
    </div>
@endsection
