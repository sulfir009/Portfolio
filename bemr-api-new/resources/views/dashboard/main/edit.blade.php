@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('main.update', $main->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row mt-1">
                <label for="hash" class="col-sm-2 col-form-label">Hash</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="hash" id="hash" value="{{$main->hash}}" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="campaigns_key_binom" class="col-sm-2 col-form-label">Campaigns key binom</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="campaigns_key_binom" id="campaigns_key_binom"
                           value="{{$main->campaigns_key_binom}}" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="aff_company_id" class="col-sm-2 col-form-label">Affise company id</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="aff_company_id" id="aff_company_id"
                           value="{{$main->aff_company_id}}" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="pid" class="col-sm-2 col-form-label">Partner id</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="pid" id="pid" value="{{$main->pid}}" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="pid" class="col-sm-2 col-form-label">Service</label>
                <div class="col-sm-6">
                    <select class="form-select" aria-label="Service" name="id_services" id="id_services">
                        @foreach($services as $service)
                            <option value="{{$service->id}}"{{ $service->id==$main->id_services ?'selected':''}}>
                                {{$service->name}}
                            </option>
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
