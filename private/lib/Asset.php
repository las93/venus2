<?php

/**
 * Manage Asset
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

/**
 * This class manage the Asset
 *
 * @category  	lib
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 *
 * @tutorial	$oAsset = new \Venus\lib\Asset;
 * 				echo $oAsset->getUrl('css/style.css');
 */
class Asset
{
	/**
	 * content asset
	 *
	 * @access private
	 * @var    string
	 */
	private $_sContent = '';

	/**
	 * assign a variable for the Asset
	 *
	 * @access public
	 * @param  string $sUrl url to get
	 * @return \Venus\lib\Asset
	 */
	public function getUrl($sUrl)
	{
		$this->_sContent = file_get_contents(str_replace('private'.DIRECTORY_SEPARATOR.'lib', '', __DIR__).'public'.DIRECTORY_SEPARATOR.PORTAIL.DIRECTORY_SEPARATOR.$sUrl);
		return $this;
	}

	/**
	 * when you echo the object, we return the content of asset
	 *
	 * @access public
	 * @return string
	 */
	public function __toString()
	{
		return $this->_sContent;
	}
}
