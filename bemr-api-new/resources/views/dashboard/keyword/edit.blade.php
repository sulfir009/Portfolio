@extends('dashboard.layouts.app')
@section('head')
@endsection
@section('content')
    <div class="container mt-3">
        <form action="{{ route('keyword.update', $keyword->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row mt-1">
                <label for="keyword" class="col-sm-2 col-form-label">Keyword</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="keyword" id="keyword"
                           value="{{$keyword->keyword}}" required>
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
