@extends('dashboard.layouts.app')
@section('head')

@endsection
@section('content')
    <div class="container">
        <div class="m-3">
            <a href="{{ route('country.create') }}" type="button" class="btn btn-success">Create</a>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Country</th>
                <th scope="col">IP address</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($countries as $key=>$item)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{ $item->country }}</td>
                    <td>{{ $item->ip_address }}</td>
                    <td><a href="{{ route('country.edit', $item->id  )}}" type="button"
                           class="btn btn-outline-info btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
