@extends('dashboard.layouts.app')
@section('head')

@endsection
@section('content')
    <div class="container">
        <div class="m-3">
            <a href="{{ route('keyword.create') }}" type="button" class="btn btn-success">Create</a>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Keyword</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($keywords as $key=>$item)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{ $item->keyword }}</td>
                    <td><a href="{{ route('keyword.edit', $item->id  )}}" type="button"
                           class="btn btn-outline-info btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
