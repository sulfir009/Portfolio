@extends('dashboard.layouts.app')
@section('head')

@endsection
@section('content')
    <div class="container">
        <div class="m-3">
            <a href="{{ route('main.create') }}" type="button" class="btn btn-success">Create</a>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Hash</th>
                <th scope="col">Binom key</th>
                <th scope="col">Country</th>
                <th scope="col">Service</th>
                <th scope="col">Partner ID</th>
                <th scope="col">Affise</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($main as $key=>$item)
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{ $item->hash }}</td>
                    <td>{{ $item->campaigns_key_binom }}</td>
                    <td>{{ $item->country }}</td>
                    <td><a class="text-decoration-none text-black"
                           href="{{ route('service.index') }}">{{ $item->service_name }}</a></td>
                    <td>{{ $item->pid }}</td>
                    <td>{{ $item->aff_company_id }}</td>
                    <td><a href="{{ route('main.edit', $item->id  )}}" type="button"
                           class="btn btn-outline-info btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
