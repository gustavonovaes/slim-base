<?php

$app->get('/', function () use ($app) {

    if ($app->Auth->isLoggedIn())
        return $app->redirect('/menu');

    return $app->redirect('/login');
});

$app->get('/maintenance_by_db', function () {
    var_dump('It will not run');
});

$app->get('/maintenance_by_middleware', $maintenance, function (){
    var_dump('It will not run');
});

$app->get('/login', $needGuest, function () use ($app) {

    $error = '';

    if ($app->Session->has('error')) {
        $error = $app->Session->get('error');
        $app->Session->del('error');
    }

    return $app->render('/main/login', array('error' => $error));
});

$app->post('/login', $needGuest, function () use ($app) {

    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

    if (false === $app->Auth->attempt($login, $pass)) {
        $app->Session->set('error', 'The username or password entered are incorrect.');
        $app->redirect('/login');
    }

    $app->redirect('/menu');
});

$app->get('/logout', $needLogged, function () use ($app) {

    if ($app->Auth->isLoggedIn())
        $app->Auth->logout();

    return $app->redirect('/login');
});

$app->get('/menu(/:submenu+)', $needLogged, function () use ($app) {

    $arr_menu_tree = array();
    $arr_breadcrumb = array();
    $arr_buttons = array();

    if (func_num_args() == 0) {

        $title = 'Initial';

        $arr_buttons[] = array(
            'icon' => 'fa-user-secret', 'name' => 'Admin',
            'link' => '/menu/admin',
            'onclick' => '',
        );

        $arr_buttons[] = array(
            'icon' => 'fa-search', 'name' => 'Test Not Found',
            'link' => '/notfound',
            'onclick' => '',
        );

        $arr_buttons[] = array(
            'icon' => 'fa-exclamation-triangle', 'name' => 'Test Maintenance',
            'link' => '/maintenance_by_db',
            'onclick' => '',
        );

        $arr_buttons[] = array(
            'icon' => 'fa-unlock-alt', 'name' => 'Test Permission',
            'link' => '/admin/user/ultra_master_admin',
            'onclick' => '',
        );

        $arr_buttons[] = array(
            'icon' => 'fa-exclamation-circle', 'name' => 'jGrow (Notification) ',
            'link' => '#',
            'onclick' => '$.jGrowl("Notification", {header: "Title Notification", position: "bottom-right"})',
        );

        $arr_buttons[] = array(
            'icon' => '', 'name' => 'Sample JS Alert',
            'link' => '#',
            'onclick' => 'alert("Title", "Text")',
        );

        $arr_buttons[] = array(
            'icon' => '', 'name' => 'Sample JS Confirm',
            'link' => '#',
            'onclick' => 'confirm("Title", "Confirmation")',
        );

        $arr_buttons[] = array(
            'icon' => '', 'name' => 'Sample Confirm YN',
            'link' => '#',
            'onclick' => 'confirmYN("Title", "Confirmation")',
        );

    } else {

        $arr_breadcrumb = func_get_arg(0);

        $title = implode(' &#8674; ', array_map('ucfirst', $arr_breadcrumb));

        /**
         * Transform:
         *
         * array( 'a', 'b', 'c' )
         *
         * in
         *
         * array (
         *      'a' => array(
         *          'b' => array(
         *              'c' => array()
         *          )
         *      )
         * )
         *
         */
        $arr_tmp = array_reverse($arr_breadcrumb);
        do {
            $arr_menu_tree = array(current($arr_tmp) => $arr_menu_tree);
        } while (next($arr_tmp));

        $submenu = key($arr_menu_tree);

        switch ($submenu) {

            case 'admin':
                $arr_menu_tree = $arr_menu_tree[$submenu];
                $submenu = is_array($arr_menu_tree) ? key($arr_menu_tree) : false;

                if (false == $submenu) {

                    $arr_buttons[] = array(
                        'icon' => 'fa-group', 'name' => 'User',
                        'link' => '/menu/admin/user',
                        'onclick' => '',
                    );

                    $arr_buttons[] = array(
                        'icon' => 'fa-lock', 'name' => 'Permission',
                        'link' => '/menu/admin/permission',
                        'onclick' => "",
                    );

                    break;
                }

                switch ($submenu) {

                    case 'user':

                        $arr_buttons[] = array(
                            'icon' => 'fa-user-plus', 'name' => 'Create',
                            'link' => '/admin/user/create',
                            'onclick' => '',
                        );

                        $arr_buttons[] = array(
                            'icon' => 'fa-edit', 'name' => 'Edit',
                            'link' => '/admin/user/edit',
                            'onclick' => '',
                        );

                        break;

                    case 'permission':

                        $arr_buttons[] = array(
                            'icon' => 'fa-plus', 'name' => 'Create',
                            'link' => '/admin/permission/create',
                            'onclick' => '',
                        );

                        $arr_buttons[] = array(
                            'icon' => 'fa-edit', 'name' => 'Edit',
                            'link' => '/admin/permission/edit',
                            'onclick' => '',
                        );

                        break;
                }

                break;
        }

        /*
         *
         * Remove from breadcrumb undefined values in url.
         *
         * Example, the route 'menu/admin/not_defined/not_defined_too'
         * equivalent to: array ( 'main', 'admin', 'not_defined', 'not_defined_too' )
         * will become: array ( 'main', 'admin' )
         */
        array_splice($arr_breadcrumb, array_search($submenu, $arr_breadcrumb) + 1);
    }

    if (empty($arr_buttons)) {
        $app->redirect('/404', 404);
    }

    return $app->render('/main/menu', array('title' => $title, 'breadcrumb' => $arr_breadcrumb, 'arr_buttons' => $arr_buttons));
});

$app->get('/change_pass', $needLogged, function () use ($app) {
    return $app->render('/main/change_pass');
});
