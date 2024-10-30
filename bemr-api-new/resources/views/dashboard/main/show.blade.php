@extends('dashboard.layouts.app')
@section('head')

@endsection
@section('content')
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
            <tr>
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
            <tr>
                <td>{{ $main->hash }}</td>
                <td>{{ $main->campaigns_key_binom }}</td>
                <td>{{ $main->country }}</td>
                <td>{{ $main->service_name }}</td>
                <td>{{ $main->pid }}</td>
                <td>{{ $main->aff_company_id }}</td>
                <td><a href="{{ route('main.edit', $main->id  )}}" type="button"
                       class="btn btn-outline-info btn-sm">Edit</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

