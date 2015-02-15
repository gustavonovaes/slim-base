<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Users
{
    protected $table = 'users';

    function run()
    {
        Capsule::schema()->dropIfExists($this->table);

        Capsule::schema()->create($this->table, function ($table) {
            $table->increments('id');
            $table->string('login', 25);
            $table->string('pass', 60);
            $table->string('email', 60);
            $table->string('last_ip', 15);
            $table->date('last_access');
            $table->boolean('active');
            $table->integer('admin');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}