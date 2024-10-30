@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('affiliates-info.update', $info->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row mt-1">
                <label for="id_country" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-6">
                    <select class="form-select" name="id_country" id="id_country">
                        <option value="">Select country code</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}" {{$info->id_country==$country->id ?'selected':''}}>
                                {{$country->country}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="postback_url" class="col-sm-2 col-form-label">Postback URL</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="postback_url" id="postback_url"
                           value="{{$info->postback_url}}" required>
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
