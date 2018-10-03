@php
    $title = $step->name;
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>{{ $step->getImgUrl() }}</td>
                        <td>{{ $step->description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection