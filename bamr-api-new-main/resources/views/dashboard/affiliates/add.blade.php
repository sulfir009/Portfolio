@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('affiliates.store') }}" method="POST">
            @csrf
            <div class="form-group row mt-1">
                <label for="pid" class="col-sm-2 col-form-label">Partner ID</label>
                <div class="col-sm-6">
                    <input class="form-control" type="number" name="pid" id="pid" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="api_key" class="col-sm-2 col-form-label">API key</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="api_key" id="api_key" required>
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
