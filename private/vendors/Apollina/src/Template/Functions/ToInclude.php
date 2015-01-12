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
class ToInclude 
{
	/**
	 * run before
	 *
	 * @access public
	 * @param  array $aParams parameters
	 * @return \Apollina\Template\ToInclude
	 */
	public function replaceBy($aParams = array()) 
	{
		if (!strstr($aParams['real_name'], '\\') && !strstr($aParams['real_name'], '/')) {

			$aParams['to_include'] = 'src/'.PORTAIL.'/View/'.$aParams['real_name'];
			$aParams['real_name'] = ''.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.PORTAIL.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR.$aParams['real_name'];
		}
		else {
			
			$aParams['to_include'] = $aParams['real_name'];
		}
		
		$sViewDirectory = str_replace('lib'.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.'Functions',
			'src/'.PORTAIL.'/View/', __DIR__);

		$sCacheDirectory = str_replace('private'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.'Functions',
						'data/cache/', __DIR__);

		$oMobileDetect = new \Mobile_Detect;

		if ($oMobileDetect->isMobile() && file_exists(str_replace('lib/Template/Functions', '../../..', __DIR__).str_replace('.tpl', 'Mobile.tpl', $aParams['real_name']))) {

			eval('$oTemplate = new \Apollina\Template("'.str_replace('.tpl', 'Mobile.tpl', $aParams['real_name']).'"); $oTemplate->fetch(null, false);');
		}
		else {

			eval('$oTemplate = new \Apollina\Template("'.str_replace("\\", "/", $aParams['real_name']).'"); $oTemplate->fetch(null, false);');
		}

		if (strstr($aParams['file'], '$_aProtectedVar[\'model\']')) {
		//return '<?php include "'.$sCacheDirectory.'".md5('.preg_replace('#^.*?([^/\\\\]+)$#', '$1', $aParams['file']).').".cac.php"; ?'.'>';
			return '<?php '.$aParams['file'].' = str_replace("\\\\", "/", '.$aParams['file'].'); if (!strstr('.$aParams['file'].', \'/\')) { '.$aParams['file'].' = "src/'.PORTAIL.'/View/".'.$aParams['file'].'; } $oMobileDetect = new \Mobile_Detect; if ($oMobileDetect->isMobile()) { if (file_exists(\''.$sCacheDirectory.'\'.md5('.str_replace('.tpl', 'Mobile.tpl',$aParams['file']).').".cac.php")) { include \''.$sCacheDirectory.'\'.md5('.str_replace('.tpl', 'Mobile.tpl',$aParams['file']).').".cac.php"; } else { include \''.$sCacheDirectory.'\'.md5('.$aParams['file'].').".cac.php"; }} else { include \''.$sCacheDirectory.'\'.md5('.$aParams['file'].').".cac.php"; } ?'.'>';
		}
		else {

			return '<?php $oMobileDetect = new \Mobile_Detect; if ($oMobileDetect->isMobile()) { if (file_exists("'.$sCacheDirectory.'".md5("'.str_replace('.tpl', 'Mobile.tpl', $aParams['to_include']).'").".cac.php")) { include "'.$sCacheDirectory.'".md5("'.str_replace('.tpl', 'Mobile.tpl', $aParams['to_include']).'").".cac.php"; } else { include "'.$sCacheDirectory.'".md5("'.$aParams['to_include'].'").".cac.php"; } } else { include "'.$sCacheDirectory.'".md5("'.$aParams['to_include'].'").".cac.php"; } ?'.'>';
		}
	}
}
