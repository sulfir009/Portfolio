@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('country.store') }}" method="POST">
            @csrf
            <div class="form-group row mt-1">
                <label for="country" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="country" id="country" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="ip_address" class="col-sm-2 col-form-label">IP address</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="ip_address" id="ip_address"
                           required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
