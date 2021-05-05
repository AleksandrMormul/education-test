@extends('layouts.app')

@section('content')

    <form class="create-ad-from" novalidate>
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Looks bad!
            </div>
        </div>
        <div class="form-group">
            <label for="validationCustom03">Description</label>
            <textarea class="form-control" rows="3" required></textarea>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                This field is required!
            </div>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="number" class="form-control" id="phone" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                This field is required!
            </div>
            <div class="alert alert-error" style="display: none"></div>
        </div>
        <div class="form-group">
            <label>Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                This field is required!
            </div>
        </div>
        <div class="form-group">
            <label>End date</label>
            <input type="date" class="form-control" id="endDate" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                This field is required!
            </div>
        </div>
        <div class="form-group">
            <label>Select files for ad</label>
            <input type="file" class="form-control-file" id="adFile">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
