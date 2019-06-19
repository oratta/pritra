@php
    $title = __('Log Workout');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <div class="p-3">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#tab1" class="nav-link" data-toggle="tab">タブ1</a>
                </li>
                <li class="nav-item">
                    <a href="#tab2" class="nav-link" data-toggle="tab">タブ2</a>
                </li>
                <li class="nav-item">
                    <a href="#tab3" class="nav-link" data-toggle="tab">タブ3</a>
                </li>
                <li class="nav-item">
                    <a href="#tab4" class="nav-link" data-toggle="tab">タブ4</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab1" class="tab-pane active">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/photo1.jpg" alt="" class="img-fluid">
                </div>
                <div id="tab2" class="tab-pane">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/photo2.jpg" alt="" class="img-fluid">
                </div>
                <div id="tab3" class="tab-pane">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/photo3.jpg" alt="" class="img-fluid">
                </div>
                <div id="tab4" class="tab-pane">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/photo4.jpg" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

@endsection