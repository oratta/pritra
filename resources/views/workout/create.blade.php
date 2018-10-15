@php
    $title = __('Log Workout');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-primary" role="alert">
            {{ session('message') }}
            </div>
        @endif
        <h1>{{ $title }}</h1>
        {{Form::open(['action' => 'WorkoutController@store'])}}
        <div class="form-group">
            <select id="menu_select" class="parent form-control" name="menu_master_id">
                <option value="" selected="selected">メニューを選択</option>
                @foreach($menuList as $index => $menu)
                    @if($selectMenuId==$index)
                        <option value="{{ $index }}" selected="selected">{{ $menu }}</option>
                    @else
                        <option value="{{ $index }}">{{ $menu }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select id="step_select" class="children form-control" name="step_master_id">
                <option value="" selected="selected">ステップを選択</option>
                @foreach($menuStepList as $menuIndex => $stepList)
                    @foreach($stepList as $stepId => $stepName)
                        @if($selectStepId==$stepId)
                            <option value="{{$stepId}}" data-val="{{$menuIndex}}" selected="selected">{{$stepName}}</option>
                        @else
                            <option value="{{$stepId}}" data-val="{{$menuIndex}}">{{$stepName}}</option>
                        @endif
                    @endforeach
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="count">
                @for($i=0;$i<$selectCount-1;$i++)
                    <option value="{{$i+1}}">{{$i+1}}</option>
                @endfor
                <option value="{{$selectCount}}" selected="selected">{{$selectCount}}</option>
                @for($i=$selectCount;$i<50;$i++)
                    <option value="{{$i+1}}">{{$i+1}}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="difficulty_type">
                @foreach($difficultyList as $index => $strength)
                    @if($index==$selectDifficulty)
                        <option value="{{$index}}" selected="selected">{{$strength}}</option>
                    @else
                        <option value="{{$index}}">{{$strength}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        {{Form::close()}}

        <h2>Last Training</h2>
        <div class="align-content-sm-center border ">
            @foreach($lastWorkoutSetList as $menuId => $workoutSet)
            <div class="col-sm">
                <div class="row">
                    <h5>{{ $menuList[$menuId] }}</h5>
                </div>
                @if($workoutSet)
                <div class="row border-bottom-0">
                    {{ $workoutSet->getStartTime() }} 〜 {{$workoutSet->getFinishTime()}}
                </div>
                <div class="row border">
                    <div class="col">
                        <ul class="list-group">
                            @foreach($workoutSet->getWorkoutArray() as $workout)
                                <li class="list-group-item">
                                step {{ $workout->step->step_number }} : {{ $workout->step->name }} <br> {{ $workout->count }} reps
                                <span class="badge badge-primary badge-pill">{{ $difficultyList[$workout->difficulty_type] }}</span>
                                </li>
                            @endforeach
                        </ul>
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
            var $children = $('.children');
            var original = $children.html();

            $(function(){
                var $menus = $('#menu_select');
                var $steps = $('#step_select');
                var $step = $('#step_select option:selected');

                var menuId = $menus.val();
                var stepMenuId = $step.data('val');

                if(menuId != stepMenuId){
                    $('#step_select').attr('disabled', 'disabled');
                }
                else{
                    $children.html(original).find('option').each(function() {
                        var eachStepMenuValue = $(this).data('val'); //data-valの値を取得

                        if (menuId != eachStepMenuValue) {
                            $(this).not(':first-child').remove();
                        }

                    });
                }

            });


            $('.parent').change(function() {

                var val1 = $(this).val();

                $children.html(original).find('option').each(function() {
                    var val2 = $(this).data('val'); //data-valの値を取得

                    if (val1 != val2) {
                        $(this).not(':first-child').remove();
                    }

                });

                if ($(this).val() == "") {
                    $children.attr('disabled', 'disabled');
                } else {
                    $children.removeAttr('disabled');
                }

            });
        </script>
    </div>
@endsection
