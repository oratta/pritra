@php
    $title = __('Menus');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Name') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $menu->id }}</td>
                        <td><a href="{{ url('menus/'.$menu->id) }}">{{ $menu->name }}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection