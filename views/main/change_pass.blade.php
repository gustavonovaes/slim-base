@extends('_layouts.base')

@section('title')
    @parent
    Change pass
@append

@section('style')
    <style>

    </style>
@stop

@section('page')
    <div class="login col-sm-4 col-sm-offset-4">
        <form class="" role="form" method="post">

            <div class="form-group">
                <label>Pass</label>
                <input name="login" type="text" class="form-control" placeholder="Pass" required autofocus>
            </div>

            <div class="form-group">
                <label>New Pass</label>
                <input name="pass" type="text" class="form-control" placeholder="New pass" required autofocus>
            </div>

            <div class="form-group">
                <label class="hiden-sm">Retype pass</label>
                <input name="pass-again" type="text" class="form-control" placeholder="Retype pass" required autofocus>
            </div>

            <button class="btn btn-lg btn-primary" type="submit"><i class="fa fa-edit"></i> Change</button>

            @if (!empty($error))
                <div class="alert alert-danger small">
                    {{ $error }}
                </div>
            @endif

        </form>
    </div>
@stop

