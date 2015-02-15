@extends('_layouts.with_nav')

@section('style')
    @parent

    <style>
        .nav .breadcrumb {
            margin: 0 7px;
            background-color: transparent;
        }
        @media (min-width: 768px) {
            .nav .breadcrumb {
                float: left;
                margin: 7px 10px;
            }
        }
        .nav .breadcrumb a {
            text-decoration: none;
        }

        .botoes .btn {
            min-width: 250px;
            max-width: 250px;
            padding: 15px;
            margin: 5px;

            -webkit-box-shadow: 2px 2px 10px 0 rgba(0,0,0,0.5);
            -moz-box-shadow: 2px 2px 10px 0 rgba(0,0,0,0.5);
            box-shadow: 2px 2px 10px 0 rgba(0,0,0,0.5);
        }
    </style>
@stop

@section('nav')
    <ol class="breadcrumb">
        <li class="root"><a href="/menu"> <i class="fa fa-folder"></i> Menu</a></li>

        <?php
            $url = '/menu';
            $max = count($breadcrumb);
        ?>

        @foreach ($breadcrumb as $k => $menu)

            <?php $url .= '/' . $menu; ?>

            @if ( ++$k == $max)
                <li class="{{ ($k+1) == $max ? 'active': ''; }}"> <i class="fa fa-folder-open-o"></i> {{ ucfirst($menu) }}</li>
            @else
                <li class="{{ ($k+1) == $max ? 'active': ''; }}"> <a href="{{ $url }}"> <i class="fa fa-folder-open"></i> {{ ucfirst($menu) }}</a></li>
            @endif


        @endforeach


    </ol>
@stop

@section('title')
    @parent
    {{ $title }}
@append

@section('page')
    @parent

    <div class="col-md-12 botoes">

        @foreach ($arr_buttons as $btn)
            <a href="{{ $btn['link'] }}" onclick="{{ str_replace("\"", "'", $btn['onclick']) }}" class="btn btn-primary btn-lg">
                <i class="fa {{ $btn['icon'] }}"> </i> {{ $btn['name'] }}
            </a>
        @endforeach

    </div>

@append