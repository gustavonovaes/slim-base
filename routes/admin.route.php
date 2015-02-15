<?php

$app->group('/admin', $needAdmin(1), function () use ($app, $needAdmin, $maintenance) {

    $app->get('/user/ultra_master_admin', $needAdmin(999), function () use ($app) {

    });

    $app->get('/user/create', $needAdmin(2), function () use ($app) {

    });

    $app->get('/user/edit', $needAdmin(2), function () use ($app) {

    });

    $app->get('/permission/create', $needAdmin(2), function () use ($app) {

    });

    $app->get('/permission/edit', $needAdmin(2), function () use ($app) {

    });

});

