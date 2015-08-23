<?php

/**
 * Manage Translation
 *
 * @category    lib
 * @author      Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright   Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license     https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version     Release: 1.0.0
 * @filesource  https://github.com/las93/venus2
 * @link        https://github.com/las93
 * @since       1.0
 */
namespace Apollina;

use \Apollina\I18n\Mock as Mock;
use \Apollina\I18n\Gettext as Gettext;
use \Apollina\I18n\Translator as Translator;

/**
 * This class manage the Translation
 *
 * @category    lib
 * @author      Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright   Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license     https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version     Release: 1.0.0
 * @filesource  https://github.com/las93/venus2
 * @link        https://github.com/las93
 * @since       1.0
 */
class I18n
{	
	/**
	 * the translation language
	 * @var string
	 */	
	private static $_sLanguage = 'fr_FR';
	
	/**
	 * the i18n directory
	 * @var string
	 */	
	private static $_sI18nDirectory = '';
	
	/**
	 * the i18n domain
	 * @var string
	 */	
	private static $_sI18nDomain = '';
	
	/**
	 * the intermediaite directory (between the language and the I18n domain)
	 * @var string
	 */	
	private static $_sIntermediaiteDirectory = '';

	/**
	 * add a callback to highlight the _() method -> exemple to add a plugin in your framework
	 * @var string
	 */
	private static $_aCallbacks = [];
	
	/**
	 * set the language if you don't want take the default language of the configuration file
	 * 
	 * @access public
	 * @param  string $sLanguage
	 * @return \Venus\lib\I18n
	 */
	public function setLanguage($sLanguage)
	{	
		self::$_sLanguage = $sLanguage;
		return $this;
	}
	
	/**
	 * get the language if you don't want take the default language of the configuration file
	 * 
	 * @access public
	 * @return string
	 */
	public function getLanguage()
	{	
		return self::$_sLanguage;
	}
	
	/**
	 * set the default I18N folder
	 * 
	 * @access public
	 * @param  string $sI18nDirectory
	 * @return \Venus\lib\I18n
	 */
	public function setI18nDirectory($sI18nDirectory)
	{	
		self::$_sI18nDirectory = $sI18nDirectory;
		return $this;
	}
	
	/**
	 * get the default I18N folder
	 * 
	 * @access public
	 * @return string
	 */
	public function getI18nDirectory()
	{	
		return self::$_sI18nDirectory;
	}
	
	/**
	 * set the default I18N Domain
	 * 
	 * @access public
	 * @param  string $sI18nDomain
	 * @return \Venus\lib\I18n
	 */
	public function setI18nDomain($sI18nDomain)
	{	
		self::$_sI18nDomain = $sI18nDomain;
		return $this;
	}
	
	/**
	 * get the default I18N Domain
	 * 
	 * @access public
	 * @return string
	 */
	public function getI18nDomain()
	{	
		return self::$_sI18nDomain;
	}

	/**
	 * add a callback
	 *
	 * @access public
	 * @param  string $sName
	 * @param  fucntion $fCallback
	 * @return void
	 */
	public static function addCallback($sName, $fCallback)
	{
	    self::$_aCallbacks[$sName] = $fCallback;
	}

	/**
	 * remove a callback
	 *
	 * @access public
	 * @param  string $sName
	 * @return void
	 */
	public static function removeCallback($sName)
	{
	    unset(self::$_aCallbacks[$sName]);
	}
	
	/**
	 * set the intermediaite folder
	 * 
	 * @access public
	 * @param  string $sIntermediaiteDirectory
	 * @return \Venus\lib\I18n
	 */
	public function setIntermediaiteDirectory($sIntermediaiteDirectory)
	{	
		self::$_sIntermediaiteDirectory = $sIntermediaiteDirectory;
		return $this;
	}
	
	/**
	 * get the intermediaite folder
	 * 
	 * @access public
	 * @return string
	 */
	public function getIntermediaiteDirectory()
	{	
		return self::$_sIntermediaiteDirectory;
	}
	
    /**
     * get a translation
     *
     * @access public
     * @param  string $sValue text to translate
     * @return string
     */
    public function _($sValue)
    {
        return $this->getText($sValue);
    }
	
    /**
     * get a translation
     *
     * @access public
     * @param  string $sValue text to translate
     * @return string
     */
    public function getText($sValue)
    {
        //ad callback to add translation before Apollina - You could see the method use in Venus2
        foreach (self::$_aCallbacks as $aOneCallback) {
            
            $sValueReturn = $aOneCallback($sValue);

            if ($sValueReturn !== '') { return $sValueReturn; }
        }
        
        if (file_exists($this->getI18nDirectory().$this->getLanguage().$this->getIntermediaiteDirectory().$this->getI18nDomain().'.json')) {
            
            if (!Translator::isConfigurated()) {
                 
                Translator::setConfig($this->getI18nDirectory().$this->getLanguage().$this->getIntermediaiteDirectory().$this->getI18nDomain().'.json');
            }
        
            return Translator::_($sValue);
        }
    	else if (!function_exists("gettext")) {
    		
    		if (!Gettext::isConfigurated()) { Gettext::setConfig($this->getLanguage(), $this->getI18nDomain(), $this->getI18nDirectory()); }	
    		
    		return Gettext::_($sValue);
    	}
    	else {
    		
    		return Mock::_($sValue);
    	}
    }
}
