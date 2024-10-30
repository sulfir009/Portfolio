@extends('dashboard.layouts.app')
@section('head')

@endsection
@section('content')
    <div class="container mt-5">
        <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="mb-6">
                <label for="file" class="col-sm-2 col-form-label">Upload File</label>
                <input type="file" class="form-control"  name="file" id="file" required>
            </div>
            <p></p>
            <div class="mb-6">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
