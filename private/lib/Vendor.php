<?php

/**
 * Vendor manage in factory
 *
 * @category  	lib
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 2.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	2.0.0
 */
namespace Venus\lib;

/**
 * This class manage the vendor class
 *
 * @category  	lib
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 2.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	2.0.0
 */
class Vendor
{
    /**
     * cache of the vendor available
     * 
     * @access private
     * @var    array
     */
    private static $_aCache = null;
    
	/**
	 * constructor - factory
	 * To call a specific vendor, you have to call this class like this :
	 * new \Venus\lib\Vendor('Apollina\Template');
	 * new \Venus\lib\Vendor('Attila\Orm');
	 * new \Venus\lib\Vendor('Mobile_Detect');
	 *
	 * @access public
	 * @param  string $sVendorName
	 * @param  mixed $mParam
	 * @return bool|object
	 */

	public static function getVendor($sVendorName, $mParam = null) {

		if (self::$_aCache === null) { self::$_aCache = include('ext/vendor/composer/autoload_classmap.php'); }
		
		if (isset(self::$_aCache[$sVendorName])) { 
		    
		    $sClassName = $sVendorName;
		    
		    if ($sVendorName === 'Apollina\Template') { 

		        return new $sClassName($mParam, str_replace('lib', '', __DIR__));
		    }
		    else if (isset($mParam)) { 
		        
		        return new $sClassName($mParam);
		    }
		    else { 
		        
		        return new $sClassName;
		    }
		}
		else { 
		    
		    return false;
		}
	}
}
