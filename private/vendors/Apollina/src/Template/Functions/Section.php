<?php

/**
 * Manage Template
 *
 * @category  	Apollina
 * @package     Apollina\Template\Functions
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 3.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	3.0.0
 */
namespace Apollina\Template\Functions;

/**
 * This class manage the Template
 *
 * @category  	Apollina
 * @package     Apollina\Template\Functions
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 3.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	3.0.0
 */
class Section 
{
	/**
	 * run before
	 *
	 * @access public
	 * @param  array $aParams parameters
	 * @return \Apollina\Template\Section
	 */
	public function replaceBy($aParams = array()) 
	{
		if (!isset($aParams['start'])) { $aParams['start'] = 0; }
		if (!isset($aParams['step'])) { $aParams['step'] = 1; }

		if (isset($aParams['name']) && isset($aParams['loop'])) {

			return '<?php for ('.$aParams['name'].' = '.$aParams['start'].' ; '.$aParams['name'].' <= '.$aParams['loop'].' ; '.$aParams['name'].' += '.$aParams['step'].') { ?>';
		}
	}
}
