<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class PermissionsUsers
{
    protected $table = 'permissions_users';

    function run()
    {
        Capsule::schema()->dropIfExists($this->table);

        Capsule::schema()->create($this->table, function ($table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('permission_id')->references('id')->on('permissions');
            $table->boolean('active');
            $table->timestamps();
        });
    }
}