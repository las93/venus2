<?php

/**
 * Http Manager
 *
 * @category  	core
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0.1
 */
namespace Venus\lib;

/**
 * Http Manager
 *
 * @category  	core
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0.1
 */
class Http
{
    /**
     * All method whom start by HTTP_ to exclude them of the PUT parameter
     * @var unknown
     */
    private static $_aHttpClassicParameter = array('HTTP_HOST', 'HTTP_CONNECTION', 'HTTP_ORIGIN', 'HTTP_USER_AGENT', 'HTTP_ACCEPT', 
        'HTTP_ACCEPT_ENCODING', 'HTTP_ACCEPT_LANGUAGE');

	/**
	 * get the put method
	 *
	 * @access public
	 * @return array
	 * 
	 * @deprecated Please use the \Venus\lib\Request::getPut();
	 */
	public static function getPut() 
	{	    
	    return Request::getPut();
	}
	
	/**
	 * Set the HTTP status
	 * 
	 * @access public
	 * @param  int $iCode
	 * @return void
	 */
	public static function setStatus($iCode)
	{
        if ($iCode === 200) { header('HTTP/1.1 200 Ok');  }
        else if ($iCode === 201) { header('HTTP/1.1 201 Created');  }
        else if ($iCode === 204) { header("HTTP/1.0 204 No Content");  }
        else if ($iCode === 403) { header('HTTP/1.1 403 Forbidden'); }
        else if ($iCode === 404) { header('HTTP/1.1 404 Not Found'); }
	}
}
