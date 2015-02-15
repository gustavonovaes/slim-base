Base structure for modular development with Slim + Blade + Illuminate Database + Bootstrap

# Slim-Base informations

## Directory Structure
```
|-- cache                            -> Cache directory Template Engine Blade
|-- database                         ->
|    |-- migrations                  ->
|    |-- seeds                       ->
|    +-- seavon                      -> Script responsible for implementation of Migrations and Seeds. (php seavon -h)
|    +-- development.sqlite          ->
|-- lib                              ->
|-- public                           -> Document Root
|    |-- assets                      ->
|    |    |-- css                    ->
|    |    |-- img                    ->
|    |    |-- js                     ->
|    |    |-- vendor                 ->
|    +-- index.php                   -> Main Script
|-- routes                           -> Contains files that implement the routes of the modules. (A module per file)
|    +-- main.route.php              -> File that implements the basic routes of the project. (login, menu, 404)
|    +-- admin.route.php             -> File that implements admin routes.
|-- vendor                           ->
|-- views                            -> Contains template files.
|    |-- _layouts                    -> Contains layout files (which are extended).
|    |-- main                        -> Contains templates of basic pages of the project (login, menu).
|    +-- 403.blade.php               -> Template displayed when a permission problem.
|    +-- 404.blade.php               -> Template displayed when the route is not found.
|    +-- 500.blade.php               -> Template displayed when an error occurs in the system.
|    +-- maintenance.blade.php       -> Template displayed when route is down for maintenance.
|    +-- fatal_error.html            -> Page displayed when a fatal error.
+-- .db                              -> PHP file with DB settings. (host, database, password)
+-- LOG.txt                          -> File containing the entire log.
```
## Dependencies

### Libs
    All libraries used in the project are defined in composer.json.

### PHP Extensions
    * php_mbstring
    * php_sqlite3
    * php_pdo_sqlite

## Slim-Base config
    All the settings are defined in /public/index.php.

## Some prints
![Print 01](https://raw.githubusercontent.com/gustavonovaes/slim-base/master/prints/01.png)
![Print 02](https://raw.githubusercontent.com/gustavonovaes/slim-base/master/prints/02.png)
![Print 03](https://raw.githubusercontent.com/gustavonovaes/slim-base/master/prints/03.png)
![Print 04](https://raw.githubusercontent.com/gustavonovaes/slim-base/master/prints/04.png)
![Print 05](https://raw.githubusercontent.com/gustavonovaes/slim-base/master/prints/05.png)