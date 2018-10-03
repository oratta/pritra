@php
    $title = $menu->name;
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>{{ $menu->getImgUrl() }}</td>
                        <td>{{ $menu->description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                @foreach($menu->steps as $step)
                <tr>
                    <td><a href="{{ url('steps/show/'.$step->id) }}">{{ $step->name }}</a></td>
                    <td>{{ $step->description }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection