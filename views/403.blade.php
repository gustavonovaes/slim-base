@extends('_layouts.base')

@section('title')
    @parent
    Unauthorized
@stop

@section('style')
    <style>
        .alert img {
            position: absolute;
            left: 30px; top: 10px;
            width: 60px;
        }
    </style>
@append

@section('page')
    <div class="col-xs-12  col-md-6 col-md-push-3 col-centered-vert">
        <div class="alert alert-info small">
            <img src="/assets/img/logo-lock.png"/>
            <h1>Unauthorized</h1>

            <h3>
                You are not authorized to access
                @if (isset($page))
                    the page "{{ $page }}"
                @else
                    this page
                @endif
                .
            </h3>

            <h3><a href="/">Click here</a> to go to main screen</h3>
        </div>
    </div>
@stop