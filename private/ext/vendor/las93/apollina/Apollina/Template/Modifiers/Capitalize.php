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
class Capitalize 
{
	/**
	 * run before
	 *
	 * @access public
	 * @param  string $sContent content to transform
	 * @param  bool $bWithNumber change the word with digit
	 * @param  bool $bRestInLowerCase the rest of word in lower case
	 * @return string
	 */
	public function replaceBy($sContent, $bWithNumber = false, $bRestInLowerCase = false) 
	{
		if ($bRestInLowerCase === true) { $sContent = strtolower(sContent); }

		if ($bWithNumber === true) { return '{ucwords('.$sContent.')}'; }
		else { return '{preg_replace("/([a-zA-Z])([a-zA-Z]+[^0-9])/", "$1$2", '.$sContent.')}'; }
	}
}
