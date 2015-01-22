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

use \Venus\core\Config as Config;

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

	    if ($sVendorName === 'Apollina\Template') { 

	        return new $sVendorName($mParam, str_replace('lib', '', __DIR__), 
	            str_replace('private'.DIRECTORY_SEPARATOR.'lib', CACHE_DIR, __DIR__));
	    }
	    else if ($sVendorName === 'Attila\Orm') { 

	        $oDbConfig = Config::get('DB')->configuration->{DB_CONF};

	        return new $sVendorName($oDbConfig->db, $oDbConfig->type, $oDbConfig->host, $oDbConfig->user, $oDbConfig->password, 
	            $oDbConfig->db);
	    }
	    else if (isset($mParam)) { 
	        
	        return new $sVendorName($mParam);
	    }
	    else { 
	        
	        return new $sVendorName;
	    }
	}
}
