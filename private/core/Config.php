<?php

/**
 * Config Manager
 *
 * @category  	core
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
namespace Venus\core;

use \Venus\lib\Debug as Debug;

/**
 * Config Manager
 *
 * @category  	core
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
class Config
{
	/**
	 * conf in a cache array
	 *
	 * @access private
	 * @var    array
	 */
	private static $_aConfCache = array();

	/**
	 * get a configuration
	 *
	 * @access public
	 * @param  string $sName name of the configuration
	 * @param  string $sPortal portal name if you specify it
	 * @param  bool $bNoDoRedirect not allowed the redirect parameter
	 * @return void
	 */
	public static function get($sName, $sPortal = null, $bNoDoRedirect = false) 
	{
	    if ($bNoDoRedirect === true) { $sNameCache = $sName.'_true'; }
	    else { $sNameCache = $sName; }
	    
		if ($sPortal === null || !is_string($sPortal)) {
		    
		    if (defined('PORTAIL')) { $sPortal = PORTAIL; }
		    else { $sPortal = ''; }
		}

		if (!isset(self::$_aConfCache[$sNameCache])) {

			$aBase = new \StdClass;

			if (file_exists(str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-local')) {

				$sJsonFile = str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-local';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-local')) {
				
				$sJsonFile = str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-local';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev') && getenv('DEV') == 1) {

				$sJsonFile = str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev') && getenv('DEV') == 1) {

				$sJsonFile = str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev') && getenv('PROD') == 1) {

				$sJsonFile = str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-prod';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev') && getenv('PROD') == 1) {

				$sJsonFile = str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-prod';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev') && getenv('PREPROD') == 1) {

				$sJsonFile = str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-pprod';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev') && getenv('PREPROD') == 1) {

				$sJsonFile = str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-pprod';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev') && getenv('RECETTE') == 1) {

				$sJsonFile = str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-rec';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-dev') && getenv('RECETTE') == 1) {

				$sJsonFile = str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-rec';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-local')) {

				$sJsonFile = str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf-local';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else if (file_exists(str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf')) {

				$sJsonFile = str_replace('core', 'src'.DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}
			else {

				$sJsonFile = str_replace('core', 'conf', __DIR__).DIRECTORY_SEPARATOR.$sName.'.conf';
				$aBase = self::_mergeAndGetConf($sJsonFile, $aBase);
			}

			if ($aBase === '') {
				
				//@todo : Error à formater => Json mal formaté
				
				trigger_error("Error in your Json format in this file : ".$sJsonFile, E_USER_NOTICE);
			}

			if (isset($aBase->redirect) && $bNoDoRedirect === false) {
			
				$aBase = self::get($sName, $aBase->redirect);
			}
			
			self::$_aConfCache[$sNameCache] = $aBase;
		}

		if (!self::$_aConfCache[$sNameCache]) {
			
			$oDebug = new Debug;
			$oDebug->error('The configuration file '.$sName.' is in error!');
		}
		
		return self::$_aConfCache[$sNameCache];
	}
	
	/**
	 * get the bundle name location or the actualy bundle name if they isn't location
	 *
	 * @access public
	 * @param  string $sName name of the configuration
	 * @return string
	 */
	public static function getBundleLocationName($sName) {

	    $oConfig = self::get($sName, null, true);

	    if (isset($oConfig->redirect)) { return $oConfig->redirect; }
	    else { return PORTAIL; }
	}

	/**
	 * get file content and merge if not exists
	 *
	 * @access private
	 * @param  string $sFileToMerge file to get
	 * @param  array $aBase base
	 * @return array
	 */
	private static function  _mergeAndGetConf($sFileToMerge, $aBase)
	{
		$aConfFiles = json_decode(file_get_contents($sFileToMerge));
		list($aConfFiles, $aBase) = self::_recursiveGet($aConfFiles, $aBase);
		return $aBase;
	}

	/**
	 * recursive merge
	 *
	 * @access private
	 * @param  array $aConfFiles
	 * @param  array $aBase
	 * @return multitype:array multitype:array
	 */
	private static function _recursiveGet($aConfFiles, $aBase)
	{
		foreach ($aConfFiles as $sKey => $mOne) {

			if (!isset($aBase->$sKey)) {

				$aBase->$sKey =  $aConfFiles->$sKey;
			}
			else if (isset($aBase[$sKey]) && is_array($mOne)) {

				$aBase->$sKey = new \StdClass;
				list($aConfFiles, $aBase) = self::_recursiveGet($mOne, $aBase->$sKey);
			}
		}

		return array($aConfFiles, $aBase);
	}
}
