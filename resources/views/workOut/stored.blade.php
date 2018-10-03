@php
$title = __('Log Workout');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>stored</h1>
        <p>ストアしました</p>
        <div>
            ・menu_type = {{$workOut->menu_type}} <br>
            ・step = {{$workOut->step}}<br/>
            ・count = {{$workOut->count}}<br/>
        </div>
    </div>
@endsection
