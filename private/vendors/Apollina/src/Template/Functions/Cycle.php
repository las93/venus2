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
class Cycle 
{
	/**
	 * run before
	 *
	 * @access public
	 * @param  array $aParams parameters
	 * @return \Apollina\Template\Cycle
	 */
	public function replaceBy($aParams = array()) 
	{
		$sValues = '';

		if (isset($aParams['values'])) { $sValues = $aParams['values']; }
		else { new \Exception('Cycle: values obligatory');}

		$sCycle = '';
		$i = 0;

		$iCountCycle = count(explode(',', $aParams['values']));

		foreach (explode(',', $aParams['values']) as $sValue) {

			$sCycle .= '<? php if ($_aProtectedVar[\'i\']/'.$i.' == round($_aProtectedVar[\'i\']/'.$i.')) { ?>'.$sValue.'<?php } ?>';
			$i++;
		}

		return $sCycle;
	}
}
