<?php

/**
 * Manage translation with gettext
 *
 * @category  	lib
 * @package		lib\Cache
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
namespace Apollina\I18n;

/**
 * Manage translation with gettext
 *
 * @category  	lib
 * @package		lib\Cache
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
class Gettext
{
	/**
	 * Indicate if the configuration is good or not
	 * @var bool 
	 */
	private static $_bConfigurated = false;
	
	/**
	 * set config jsut for the first time 
	 * 
	 * @access private
	 * @return void
	 */	
	public static function setConfig($sLanguage, $sDomain, $sDirectory)
	{	
		putenv('LC_ALL='.$sLanguage);
		setlocale(LC_ALL, $sLanguage);
		
		bindtextdomain($sDomain, $sDirectory);
		textdomain($sDomain);
		
		$this->_bConfigurated = true;
	}
	
	/**
	 * set config just for the first time 
	 * 
	 * @access private
	 * @return bool
	 */
	public static function isConfigurated()
	{	
		return $this->_bConfigurated;
	}
	
	/**
	 * get a value
	 *
	 * @access public
	 * @param  string $sName name of the session
	 * @param  int $iFlags flags
	 * @param  int $iTimeout expiration of cache
	 * @return mixed
	 */
	public static function _($sValue)
	{ 
	    return _($sValue);
	}
}
