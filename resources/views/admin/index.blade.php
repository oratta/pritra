@php
    $title = __('admin menu');
@endphp
@extends('layouts.sample')
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        <h2>add user</h2>
        <div class="form-group">
            <form>
                <div class="form-group">
                    <label>name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label>email</label>
                    <input type="text" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label>password</label>
                    <input type="text" name="password" class="form-control">
                </div>
                <button type="submit">register</button>
            </form>
        </div>
    </div>
@endsection
