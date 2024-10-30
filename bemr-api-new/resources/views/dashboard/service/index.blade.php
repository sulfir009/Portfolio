@extends('dashboard.layouts.app')
@section('head')

@endsection
@section('content')
    <div class="container">
        <div class="m-3">
            <a href="{{ route('service.create') }}" type="button" class="btn btn-success">Create</a>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Country</th>
                <th scope="col">Business number</th>
                <th scope="col">Campaign code</th>
                <th scope="col">Keyword</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $key=>$item)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->country }}</td>
                    <td>{{ $item->business_number }}</td>
                    <td>{{ $item->campaign_code }}</td>
                    <td>{{ $item->keyword }}</td>
                    <td><a href="{{ route('service.edit', $item->id  )}}" type="button"
                           class="btn btn-outline-info btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
