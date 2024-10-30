@extends('dashboard.layouts.app')
@section('head')

@endsection
@section('content')
    <div class="container">
        <table class="table">
            <div class="m-3">
                <a href="{{ route('campaign-code.create') }}" type="button" class="btn btn-success">Create</a>
            </div>
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($campaign_codes as $key=>$item)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{ $item->campaign_code }}</td>
                    <td><a href="{{ route('campaign-code.edit', $item->id  )}}" type="button"
                           class="btn btn-outline-info btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
