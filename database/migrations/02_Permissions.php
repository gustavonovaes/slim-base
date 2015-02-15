<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Permissions
{
    protected $table = 'permissions';

    function run()
    {
        Capsule::schema()->dropIfExists($this->table);

        Capsule::schema()->create($this->table, function ($table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->timestamps();
        });
    }
}