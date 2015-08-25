<?php

/**
 * bootstrap of the demo
 *
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
error_reporting(E_ALL);
ini_set('display_error', 1);

set_include_path(get_include_path().PATH_SEPARATOR.str_replace('public', 'bundles', __DIR__));

require 'conf/AutoLoad.php';

\Venus\lib\Debug::activateDebug();

$oRouter = new \Venus\core\Router();
$oRouter->run();