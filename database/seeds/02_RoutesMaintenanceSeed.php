<?php

class RoutesMaintenanceModel extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'routes_maintenance';
}

class RoutesMaintenanceSeed
{

    function run()
    {
        $obj = new RoutesMaintenanceModel();

        $obj->route = '/maintenance_by_db';
        $obj->active = true;
        $obj->user_id = 0;

        $obj->save();
    }

}