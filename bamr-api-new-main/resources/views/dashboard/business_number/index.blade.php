@extends('dashboard.layouts.app')
@section('head')

@endsection
@section('content')
    <div class="container">
        <div class="m-3">
            <a href="{{ route('business-number.create') }}" type="button" class="btn btn-success">Create</a>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Number</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($business_numbers as $key=>$item)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{ $item->business_number }}</td>
                    <td><a href="{{ route('business-number.edit', $item->id  )}}" type="button"
                           class="btn btn-outline-info btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
