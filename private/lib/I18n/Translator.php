<?php

/**
 * Manage translation with a classic translator
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
namespace Venus\lib\I18n;

/**
 * Manage translation with a classic translator
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
class Translator
{
	/**
	 * Indicate if the configuration is good or not
	 * @var bool
	 */	
	private static $_bConfigurated = false;
	
	/**
	 * Indicate if the configuration is good or not
	 * @var bool
	 */
	private static $_aTranslator = false;
	
	/**
	 * set config jsut for the first time
	 *
	 * @access private
	 * @return void
	 */
	public static function setConfig($sFile)
	{
		$this->_aTranslator = json_decode($sFile);
		$this->_bConfigurated = true;
	}
	
	/**
	 * set config jsut for the first time
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
	 * @param  string $sValue value to translate
	 * @return mixed
	 */
	public static function _($sValue)
	{    
	    return $this->_aTranslator[$sValue];
	}
}
