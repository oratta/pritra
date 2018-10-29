@php
    $title = __('admin menu');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <h2>add user</h2>
        <div class="form-group">
            {{Form::open(['action' => 'AdminController@addUser'])}}
            <div class="form-group">
                    <label>name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label>email</label>
                    <input type="text" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label>password</label>
                    <input type="text" name="password" class="form-control">
                </div>
                <button type="submit">register</button>
            {{Form::close()}}
        </div>
        <h2>view user</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Type') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->type }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
