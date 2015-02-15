<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class RoutesMaintenance
{
    protected $table = 'routes_maintenance';

    function run()
    {
        Capsule::schema()->dropIfExists($this->table);

        Capsule::schema()->create($this->table, function ($table) {
            $table->increments('id');
            $table->string('route', 100);
            $table->boolean('active');
            $table->integer('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }
}