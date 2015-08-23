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
class ConfigLoad 
{
	/**
	 * run before
	 *
	 * @access public
	 * @param  array $aParams parameters
	 * @return \Apollina\Template\ConfigLoad
	 */
	public function replaceBy($aParams = array()) 
	{
		$sFile = '';

		if (isset($aParams['file'])) { $sFile = $aParams['file']; }
		else { new \Exception('ConfigLoad: file obligatory');}

		$sViewDirectory = str_replace('lib'.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.'Function',
			'src'.DIRECTORY_SEPARATOR.PORTAL.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR, __DIR__);

		$aConfVars = parse_ini_file($sViewDirectory.$sFile);

		$sContent = '';
		$sContent = $this->_constructVar($sContent, $aConfVars, '$_aProtectedVar[\'app\'][\'config\']');

		return '<?php '.$sContent.'; ?>';
	}

	/**
	 * constructor of var on recursive mode
	 *
	 * @access private
	 * @param  string $sContent content to return
	 * @param  array $aConfVars var to parse
	 * @return unknown
	 */
	private function _constructVar($sContent, $aConfVars, $sVarTemplate) 
	{
		foreach ($aConfVars as $mKey => $mOne) {

			if (is_array($mOne)) {

				$sContent .= $sVarTemplate.'[\''.$mKey.'\'] = array(); ';
				$sContent = $this->_constructVar($sContent, $mOne, $sVarTemplate.'[\''.$mKey.'\']');
			}
			else {

				$sContent .= $sVarTemplate.'[\''.$mKey.'\'] = "'.$mOne.'"; ';
			}
		}

		return $sContent;
	}
}
