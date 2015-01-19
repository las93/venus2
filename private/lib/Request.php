<?php

/**
 * Manage Request
 *
 * @category  	lib
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
namespace Venus\lib;

/**
 * This class manage the request
 *
 * @category  	lib
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
class Request
{
	/**
	 * if the request is ajax
	 *
	 * @access public
	 * @param  string $sName name of the template
	 * @return bool
	 */
	public static function isXmlHttpRequest()
	{
		if (!self::isCliRequest()) {

			if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

				return true;
			}
			else {

				return false;
			}
		}
	}

	/**
	 * if the request is http (web site or web service)
	 *
	 * @access public
	 * @return bool
	 */
	public static function isHttpRequest()
	{
		if (isset($_SERVER) && isset($_SERVER['HTTP_HOST'])) { return true; }
		else { return false; }
	}

	/**
	 * if the request is https (web site or web service)
	 *
	 * @access public
	 * @return bool
	 */
	public static function isHttpsRequest()
	{
		if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') { return true; }
		else { return false; }
	}

	/**
	 * if the request is http (web site or web service)
	 *
	 * @access public
	 * @return bool
	 */
	public static function isCliRequest()
	{
		$sSapiType = php_sapi_name();

		if (substr($sSapiType, 0, 3) == 'cgi' || defined('STDIN')) { return true; }
		else { return false; }
	}

	/**
	 * if the request is http (web site or web service)
	 *
	 * @access public
	 * @return bool
	 */
	public static function getPreferredLanguage()
	{
		if (!self::isCliRequest()) { return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); }
		else { return ''; }
	}

	/**
	 * if the request is http (web site or web service)
	 *
	 * @access public
	 * @return bool
	 */
	public static function getParameters()
	{
		if (isset($_GET)) { return $_GET; }
		else { return array(); }
	}

	/**
	 * if the request is http (web site or web service)
	 *
	 * @access public
	 * @return bool
	 */
	public static function getPostParameters()
	{
		if (isset($_POST)) { return $_POST; }
		else { return array(); }
	}
}
