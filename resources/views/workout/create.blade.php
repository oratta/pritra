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
            <select id="menu_select" class="form-control" name="menu_master_id">
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
            <select id="step_select" class="form-control" name="step_master_id">
                <option value="" selected="selected">ステップを選択</option>
                @foreach($menuStepList as $menuIndex => $stepList)
                    @foreach($stepList as $stepId => $stepName)
                        @if($selectStepId==$stepId)
                            <option value="{{$stepId}}" data-menu="{{$menuIndex}}" selected="selected">{{$stepName}}</option>
                        @else
                            <option value="{{$stepId}}" data-menu="{{$menuIndex}}">{{$stepName}}</option>
                        @endif
                    @endforeach
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select id='count_select' class="form-control" name="count">
                @for($i=0;$i<$selectCount-1;$i++)
                    <option value="{{$i+1}}">{{$i+1}}</option>
                @endfor
                <option value="{{$selectCount}}" selected="selected">{{$selectCount}}</option>
                @for($i=$selectCount;$i<150;$i++)
                    <option value="{{$i+1}}">{{$i+1}}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <select id='difficulty_select' class="form-control" name="difficulty_type">
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
                    {{ $workoutSet->getStartTime() }} 〜 {{$workoutSet->getEndTime()}}
                </div>
                <div class="row border">
                    <div class="col">
                        <div class="list-group">
                            @foreach($workoutSet->getWorkoutArray() as $workout)
                                <button class="list-group-item text-left click-input" data-menu="{{$workout->menu_master_id}}" data-step="{{$workout->step_master_id}}" data-reps="{{$workout->count}}" data-difficulty="{{$workout->difficulty_type}}">
                                step {{ $workout->step->step_number }} : {{ $workout->step->name }} <br> {{ $workout->count }} reps
                                <span class="badge badge-primary badge-pill">{{ $difficultyList[$workout->difficulty_type] }}</span>
                                </button>
                            @endforeach
                            @if($workoutSet->nextLevelWorkout)
                                <button class="list-group-item list-group-item-info text-left" data-menu="{{$workoutSet->nextLevelWorkout->menu_master_id}}" data-step="{{$workoutSet->nextLevelWorkout->step_master_id}}" data-reps="{{$workoutSet->nextLevelWorkout->count}}" data-difficulty="3">>
                                    NextStep<br>
                                    @php if(!$workoutSet->nextLevelWorkout->step){dump($workoutSet->nextLevelWorkout);exit;} @endphp
                                    step {{ $workoutSet->nextLevelWorkout->step->step_number }} : {{ $workoutSet->nextLevelWorkout->step->name }} <br>
                                    {{ $workoutSet->nextLevelWorkout->min_rep_count }} reps <br>
                                    {{ $workoutSet->nextLevelWorkout->set_count }} set
                                </button>
                            @endif
                        </div>
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
            var $stepSelect = $('#step_select');
            var originalStepSelect = $stepSelect.html();

            $(function(){
                var $menus = $('#menu_select');
                var $step = $('#step_select option:selected');

                var menuId = $menus.val();
                var stepMenuId = $step.data('menu');

                if(menuId != stepMenuId){
                    $('#step_select').attr('disabled', 'disabled');
                }
                else{
                    initSelect(menuId);
                }
            });

            $('.click-input').click(function(){
                $('#step_select option:selected').removeAttr('selected');
                $('#menu_select option:selected').removeAttr('selected');
                $('#count_select option:selected').removeAttr('selected');
                $('#difficulty_select option:selected').removeAttr('selected');

                var targetMenuId = $(this).data('menu');
                var targetStepId = $(this).data('step');
                var targetRepCount = $(this).data('reps');
                var targetDifficulty = $(this).data('difficulty');

                $('#menu_select').children('option[value="' + targetMenuId + '"]').attr('selected', 'selected');

                initSelect(targetMenuId);
                var stepSelect = $stepSelect.children('option[value="' + targetStepId + '"]');
                stepSelect.attr('selected', 'selected');

                $('#count_select').children('option[value="' + targetRepCount + '"]').attr('selected', 'selected');
                $('#difficulty_select').children('option[value="' + targetDifficulty + '"]').attr('selected', 'selected');
            })

            function initSelect(targetMenuId) {
                if (targetMenuId == "") {
                    $stepSelect.attr('disabled', 'disabled');
                } else {
                    trimStepOption(targetMenuId);
                    $stepSelect.removeAttr('disabled');
                }
            }

            function trimStepOption(targetMenuId){
                $stepSelect.html(originalStepSelect).find('option').each(function() {
                    var menuId = $(this).data('menu'); //data-valの値を取得

                    if (menuId != targetMenuId) {
                        $(this).not(':first-child').remove();
                    }
                });
            }

            $('#menu_select').change(function() {
                var menuId = $(this).val();
                initSelect(menuId);
            });
        </script>
    </div>
@endsection
