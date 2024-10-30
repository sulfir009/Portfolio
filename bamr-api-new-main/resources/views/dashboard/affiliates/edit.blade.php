@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-5">
        <h3>Edit affiliate</h3>
        <form action="{{ route('affiliates.update',$affiliate->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row mt-1">
                <label for="pid" class="col-sm-2 col-form-label">Business number</label>
                <div class="col-sm-6">
                    <input class="form-control" type="number" name="pid" id="pid"
                           value="{{$affiliate->pid}}" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <label for="api_key" class="col-sm-2 col-form-label">API key</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="api_key" id="api_key"
                           value="{{$affiliate->api_key}}" required>
                </div>
            </div>
            <div class="form-group row mt-1">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Country</th>
                <th scope="col">Postback URL</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <h4 class="mt-5">Postback</h4>
            @foreach($info as $key=>$item)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{ $item->country }}</td>
                    <td>{{ $item->postback_url }}</td>
                    <td><a href="{{ route('affiliates-info.edit', $item->info_id  )}}" type="button"
                           class="btn btn-outline-info btn-sm">Edit</a>
                    </td>
                    <td>
                        <form class="form form-delete delete-form"
                              action="{{ route('affiliates-info.destroy', $item->info_id  ) }}"
                              method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-outline-danger btn-sm btn-delete" type="button">Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <h5 class="mt-5">Add new postback</h5>
        <div class="container mt-5">
            <form action="{{ route('affiliates-info.store') }}" method="POST">
                @csrf
                <div class="form-group row mt-1">
                    <label for="id_country" class="col-sm-2 col-form-label">Country</label>
                    <div class="col-sm-6">
                        <select class="form-select" name="id_country" id="id_country">
                            <option value="">Select country code</option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->country}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mt-1">
                    <label for="postback_url" class="col-sm-2 col-form-label">Postback URL</label>
                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="postback_url" id="postback_url" required>
                    </div>
                </div>
                <input type="hidden" name="id_affiliates" value="{{$affiliate->id}}">
                <div class="form-group row mt-1">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">Add new postback</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @vite('resources/js/edit_affiliates.js')
@endsection
