<?php

/**
 * bootstrap of the framework for the script CLI
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

set_include_path(get_include_path().PATH_SEPARATOR.__DIR__);

require 'conf/AutoLoad.php';

$oRouter = new \Venus\core\Router();
$oRouter->run();
