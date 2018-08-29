@php
    $title = __('Steps');
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
                    <th>{{ __('Menu') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($steps as $step)
                    <tr>
                        <td>{{ $step->id }}</td>
                        <td><a href="{{ url('steps/'.$step->id) }}">{{ $step->name }}</a></td>
                        <td>{{ $step->menu->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection