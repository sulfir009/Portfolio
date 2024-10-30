@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('campaign-code.update', $campaign_code->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row mt-1">
                <label for="campaign_code" class="col-sm-2 col-form-label">Campaign code</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="campaign_code" id="campaign_code"
                           value="{{$campaign_code->campaign_code}}" required>
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
