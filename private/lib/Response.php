<?php

/**
 * Manage Form
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

use \Venus\lib\Response\Json as Json;
use \Venus\lib\Response\Mock as Mock;
use \Venus\lib\Response\Yaml as Yaml;

/**
 * This class manage the Form
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
class Response
{
	/**
	 * the translation language
	 * @var string
	 */	
	private static $_sKinbfOfReturn = 'json';
	
	/**
	 * set the language if you don't want take the default language of the configuration file
	 *
	 * @access public
	 * @param  string $sKinbfOfReturn
	 * @return \Venus\lib\Response
	 */
	public static function setKinbfOfReturn($sKinbfOfReturn)
	{
		self::$_sKinbfOfReturn = $sKinbfOfReturn;
		return $this;
	}
	
	/**
	 * translate the content
	 *
	 * @access public
	 * @param  mixed $mContent content to translate
	 * @return mixed
	 */
	public function translate($mContent)
	{
		if (self::$_sKinbfOfReturn === 'yaml') { return Yaml::translate($mContent); }
		else if (self::$_sKinbfOfReturn === 'mock') { return Mock::translate($mContent); }
		else { return Json::translate($mContent); }  
	}
}
