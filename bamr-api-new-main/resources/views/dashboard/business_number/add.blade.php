@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('business-number.store') }}" method="POST">
            @csrf
            <div class="form-group row mt-1">
                <label for="business_number" class="col-sm-2 col-form-label">Business number</label>
                <div class="col-sm-6">
                    <input class="form-control" type="number" name="business_number" id="business_number" required>
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
