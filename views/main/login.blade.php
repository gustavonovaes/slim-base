@extends('_layouts.base')

@section('title')
    @parent
    Login
@append

@section('style')
    <style>
        div.login {
            margin-top: 3em;
            border-radius: 2em;
        }

        div.logo > img {
            width: 50%;
            margin: 1em auto;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
             -moz-box-sizing: border-box;
                  box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[name="login"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[name="pass"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        div.alert {
            margin-top: 10px;
        }
    </style>
@stop

@section('page')
    <div class="login col-md-4 col-md-offset-4">
        <form class="form-signin" role="form" method="post">
            <div class="logo">
                <img class="img-responsive center-block" src="/assets/img/logo.png" />
            </div>

            <div class="form-group {{ isset($error) ? 'has-herror': ''; }}">
            <input name="login" type="text" class="form-control" placeholder="Login" required autofocus>
            <input name="pass" type="password" class="form-control" placeholder="Pass" required>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-sign-in"></i> Enter</button>

            @if (!empty($error))
                <div class="alert alert-danger small">
                    {{ $error }}
                </div>
            @endif

        </form>
    </div>
@stop

