@extends("_layouts.base")

@section('style')
    <style>
        .navbar {
            border-radius: 0;
            border: none;
            -webkit-box-shadow: 0 5px 32px 0 rgba(0,0,0,0.3);
            -moz-box-shadow: 0 5px 32px 0 rgba(0,0,0,0.3);
            box-shadow: 0 5px 32px 0 rgba(0,0,0,0.3);
        }
        .navbar-brand {
            padding: 5px;
            border-radius: 0;
        }
        .navbar-brand img {
            width: 35px;
        }

        /* Resolve scroll bar */
        .navbar-form {
            margin-right: 0;
        }
    </style>
@stop

@section('page')

    <nav class="navbar navbar-default text-right" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="/assets/img/logo-xs.png"/>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    @section('nav')
                    @show
                </ul>


                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Options: <span class="caret"></span></a>
                        <ul class="dropdown-menu " role="menu">
                            <li><a href="#" onclick="popup('/change_pass',500,768)"> <i class="fa fa-unlock"> </i> Change pass</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>

                    <form class="navbar-form navbar-right" action="/logout" role="form">
                        <button type="submit" class="btn btn-danger"> <i class="fa fa-sign-out"></i> Logout</button>
                    </form>

                </ul>

            </div>
        </div>
    </nav>
@stop