@php
$title = __('Log Workout');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>stored</h1>
        <p>ストアしました</p>
        <div class="table-bordered">
            <table class="table">
                <tr>
                    <td>menu</td><td>{{$workout->menu->name}}</td>
                </tr>
                <tr>
                    <td>step</td><td>{{$workout->step->name}}</td>
                </tr>
                <tr>
                    <td>count</td><td>{{$workout->count}}</td>
                </tr>
                <tr>
                    <td>difficulty</td><td>{{$difficultyList[$workout->difficulty_type]}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
