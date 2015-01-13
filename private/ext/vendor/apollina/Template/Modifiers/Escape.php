<?php

/**
 * Manage Template
 *
 * @category  	Apollina
 * @package     Apollina\Template\Modifiers
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 3.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	3.0.0
 */
namespace Apollina\Template\Modifiers;

/**
 * This class manage the Template
 *
 * @category  	Apollina
 * @package     Apollina\Template\Modifiers
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 3.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	3.0.0
 */
class Escape 
{
	/**
	 * run before
	 * replace {$foo |date_format:"%Y/%m/%d" by {date("%Y/%m/%d", $foo)
	 *
	 *
	 * @access public
	 * @param  string $sContent parameters
	 * @return \Apollina\Template\Mailto
	 */
	public function replaceBy($sContent, $sOptionToEscape = '"html"', $sEncoding = '"UTF-8"') 
	{
		$sOptionToEscape = str_replace("'", '"', $sOptionToEscape);
		$sEncoding = str_replace("'", '"', $sEncoding);

		if ($sOptionToEscape === '"htmlall"') {

			return '{htmlentities('.$sContent.', ENT_COMPAT | ENT_HTML401, '.$sEncoding.')}';
		}
		else if ($sOptionToEscape === '"url"') {

			return '{rawurlencode('.$sContent.')}';
		}
		else if ($sOptionToEscape === '"urlpathinfo"') {

			return '{str_replace("%2F", "/", rawurlencode('.$sContent.'))}';
		}
		else if ($sOptionToEscape === '"quotes"') {

			return '{preg_replace("%(?<!\\\\\\\\)\'%", "\\\'", '.$sContent.')}';
		}
		else if ($sOptionToEscape === '"javascript"') {

			return '{strtr('.$sContent.', array("\\\\" => "\\\\\\\\", "\'" => "\\\\\'", "\"" => "\\\\\"", "\\r" => "\\\\r", "\\n" => "\\\n", "</" => "<\/" ))}';
		}
		else {

			return '{htmlspecialchars('.$sContent.', ENT_COMPAT | ENT_HTML401, '.$sEncoding.')}';
		}
	}
}
