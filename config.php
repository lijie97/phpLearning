<?php

$debug = true;
if ($debug) {
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors', 1);
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '123456');
define('DB_NAME', 'site_recette');
define('GB_TABLE_RECIPES', 'recipes');
define('GB_TABLE_COMMENTS', 'comments');
define('GB_TABLE_INGREDIENT', 'ingredient');
define('ADMIN_TABLE_NAME', 'users');

define('PER_PAGE_GB', 5);


/**end of file**/