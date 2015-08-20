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

class Indent
{
	/**
	 * run before
	 * replace {$foo |date_format:"%Y/%m/%d" by {date("%Y/%m/%d", $foo)
	 *
	 *
	 * @access public
	 * @param  string $sContent parameters
	 * @param  string $iNumberCharacterToIndent number character to indent
	 * @param  string $sCharacterToIndent kind of charater use to indent
	 * @return \Apollina\Template\Mailto
	 */
	public function replaceBy($sContent, $iNumberCharacterToIndent = 4, $sCharacterToIndent = "' '") 
	{
		return '{preg_replace(\'!^!m\',str_repeat('.$sCharacterToIndent.','.$iNumberCharacterToIndent.'),'.$sContent.')}';
	}
}
