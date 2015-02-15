@extends('_layouts.base')

@section('title')
    @parent
    Maintenance
@stop

@section('style')
    <style>
        .alert img {
            position: absolute;
            left: 30px; top: 10px;
            width: 60px;
        }
        .alert .mensagem {
            text-align: center;
        }
    </style>
@append

@section('page')
    <div class="col-xs-12 col-md-6 col-md-push-3 col-centered-vert">
        <div class="alert alert-warning small">
            <img src="/assets/img/logo-puzzle.png"/>
            <h1>Maintenance</h1>

            <h3 class="mensagem">
                @if (isset($page))
                    The page "{{ $page }}"
                @else
                    This page
                @endif
                is in maintenance
            </h3>
            <h3>Please, try again later.</h3>

            <h3><a href="/">Click here</a> to go to main screen</h3>
        </div>
    </div>
@stop