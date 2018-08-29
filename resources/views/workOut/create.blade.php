<h1>Log Workout</h1>
{{Form::open(['action' => 'WorkOutController@store'])}}
<select class="parent" name="menu_type">
    <option value="" selected="selected">メニューを選択</option>
    @foreach($menuList as $index => $menu)
        <option value="{{ $index }}">{{ $menu }}</option>
    @endforeach
</select>
<select class="children" name="step" disabled>
    <option value="" selected="selected">ステップを選択</option>
    @foreach($menuStepList as $menuIndex => $stepList)
        @foreach($stepList as $stepNumber => $stepName)
            <option value="{{$stepNumber}}" data-val="{{$menuIndex}}">{{$stepName}}</option>
        @endforeach
    @endforeach
</select>
<select name="count">
    @for($i=0;$i<19;$i++)
        <option value="{{$i+1}}">{{$i+1}}</option>
    @endfor
    <option value="20" selected="selected">20</option>
    @for($i=20;$i<50;$i++)
        <option value="{{$i+1}}">{{$i+1}}</option>
    @endfor
</select>
<select name="difficulty_type">
    @foreach($strengthList as $index => $strength)
        <option value="{{$index}}">{{$strength}}</option>
    @endforeach
</select>
{{Form::submit()}}
{{Form::close()}}

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