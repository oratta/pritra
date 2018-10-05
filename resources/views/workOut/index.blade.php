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
                @foreach($workOutList as $id=>$workOut)
                    <tr>
                        <td>{{ $workOut->timeStamp }}</td>
                        <td>{{ $workOut->menu_type }}</td>
                        <td>{{ $workOut->step }}</td>
                        <td>{{ $workOut->count }}</td>
                        <td>{{ $workOut->user->id }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <a href="{{url("/workout/create")}}">log</a>
    </div>
@endsection
