@php
    $title = __('View Workout Log');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>
                        日付
                    </th>
                    <th>
                        メニュー
                    </th>

                    <th>
                        ステップ
                    </th>
                    <th>
                        回数
                    </th>
                    <th>
                        id
                    </th>
                </tr>
                @foreach($workoutList as $id=>$workout)
                    <tr>
                        <td>{{ $workout->timeStamp }}</td>
                        <td>{{ $workout->menu_type }}</td>
                        <td>{{ $workout->step }}</td>
                        <td>{{ $workout->count }}</td>
                        <td>{{ $workout->user->id }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <a href="{{url("/workout/create")}}">log</a>
    </div>
@endsection