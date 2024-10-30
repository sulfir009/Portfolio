@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('service.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row mt-1">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="name" id="name"
                           value="{{$service->name}}" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="id_country" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-6">
                    <select class="form-select" name="id_country" id="id_country">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}"
                                {{$service->id_country==$country->id ?'selected':''}}>
                                {{$country->country}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="id_business_number" class="col-sm-2 col-form-label">Business number</label>
                <div class="col-sm-6">
                    <select class="form-select" name="id_business_number"
                            id="id_business_number">
                        @foreach($business_numbers as $business_number)
                            <option value="{{$business_number->id}}"
                                {{$service->id_business_number==$business_number->id ?'selected':''}}>
                                {{$business_number->business_number}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="id_campaign_code" class="col-sm-2 col-form-label">Campaign code</label>
                <div class="col-sm-6">
                    <select class="form-select" name="id_campaign_code"
                            id="id_campaign_code">
                        @foreach($campaign_codes as $campaign_code)
                            <option value="{{$campaign_code->id}}"
                                {{$service->id_campaign_code==$campaign_code->id ?'selected':''}}>
                                {{$campaign_code->campaign_code}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="id_keyword" class="col-sm-2 col-form-label">Keyword</label>
                <div class="col-sm-6">
                    <select class="form-select" name="id_keyword" id="id_keyword">
                        @foreach($keywords as $keyword)
                            <option value="{{$keyword->id}}"
                                {{$service->id_keyword==$keyword->id ?'selected':''}}>
                                {{$keyword->keyword}}</option>
                        @endforeach
                    </select>
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
