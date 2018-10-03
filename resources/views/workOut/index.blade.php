@php
    $title = __('View Workout Log');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>ワークアウト一覧</h1>
        <table>
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
            </tr>
            @foreach($workOutList as $id=>$workOut)
                <tr>
                    <td>{{ $workOut->timeStamp }}</td>
                    <td>{{ $workOut->menu_type }}</td>
                    <td>{{ $workOut->step }}</td>
                    <td>{{ $workOut->count }}</td>
                </tr>
            @endforeach
        </table>
        <a href="{{url("/workout/create")}}">log</a>
    </div>
@endsection
