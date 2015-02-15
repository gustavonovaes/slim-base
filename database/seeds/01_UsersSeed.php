<?php

class UsersModel extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'users';
}

class UsersSeed
{

    function run()
    {
        $obj = new UsersModel();

        $obj->login = 'admin';
        $obj->pass = password_hash('admin', PASSWORD_DEFAULT);
        $obj->email = 'smr@mercantilreal.com.br';
        $obj->last_ip = '127.0.0.1';
        $obj->last_access = date('Y-m-d');
        $obj->active = '1';
        $obj->admin = 3;

        $obj->save();
    }

}