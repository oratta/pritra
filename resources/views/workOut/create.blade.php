@php
    $title = __('Log Workout');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        {{Form::open(['action' => 'WorkOutController@store'])}}
        <div class="form-group">
            <select class="parent form-control" name="menu_master_id">
                <option value="" selected="selected">メニューを選択</option>
                @foreach($menuList as $index => $menu)
                    <option value="{{ $index }}">{{ $menu }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select class="children form-control" name="step_master_id" disabled>
                <option value="" selected="selected">ステップを選択</option>
                @foreach($menuStepList as $menuIndex => $stepList)
                    @foreach($stepList as $stepNumber => $stepName)
                        <option value="{{$stepNumber}}" data-val="{{$menuIndex}}">{{$stepName}}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="count">
                @for($i=0;$i<19;$i++)
                    <option value="{{$i+1}}">{{$i+1}}</option>
                @endfor
                <option value="20" selected="selected">20</option>
                @for($i=20;$i<50;$i++)
                    <option value="{{$i+1}}">{{$i+1}}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="difficulty_type">
                @foreach($difficultyList as $index => $strength)
                    <option value="{{$index}}">{{$strength}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        {{Form::close()}}
        <h2>Last Training</h2>
        <div class="row border border-primary">
            @foreach($lastLogList as $menuId => $workOutLog)
            <div class="col-sm">
                <div class="row">
                    {{ $menuList[$menuId] }}
                </div>
                @if($workOutLog)
                <div class="row border-bottom-0">
                    {{ $workOutLog->created_at }}
                </div>
                <div class="row border">
                    <div class="col">
                        {{ $workOutLog->step->name }}
                    </div>
                    <div class="col">
                        {{ $workOutLog->count }}
                    </div>
                    <div class="col">
                        {{ $difficultyList[$workOutLog->difficulty_type] }}
                    </div>
                </div>
                @else
                    no log.
                @endif
            </div>
            @endforeach
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
            var $children = $('.children'); //都道府県の要素を変数に入れます。
            var original = $children.html(); //後のイベントで、不要なoption要素を削除するため、オリジナルをとっておく

            //地方側のselect要素が変更になるとイベントが発生
            $('.parent').change(function() {

                //選択された地方のvalueを取得し変数に入れる
                var val1 = $(this).val();

                //削除された要素をもとに戻すため.html(original)を入れておく
                $children.html(original).find('option').each(function() {
                    var val2 = $(this).data('val'); //data-valの値を取得

                    //valueと異なるdata-valを持つ要素を削除
                    if (val1 != val2) {
                        $(this).not(':first-child').remove();
                    }

                });

                //地方側のselect要素が未選択の場合、都道府県をdisabledにする
                if ($(this).val() == "") {
                    $children.attr('disabled', 'disabled');
                } else {
                    $children.removeAttr('disabled');
                }

            });
        </script>
    </div>
@endsection
