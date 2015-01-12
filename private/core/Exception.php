<?php

/**
 * Exception Manager
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

use \Exception as GlobalException;

/**
 * Exception Manager
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

class Exception extends GlobalException {

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
	 * @param  string sName name of the configuration
	 * @return void
	 */

	public function __construct($message, $code = 0, Exception $previous = null) {

		parent::__construct($message, $code, $previous);
	}

	/**
	 * rewrite the string when we use the Excetion in echo
	 *
	 * @access public
	 * @return string
	 */

	public function __toString() {

		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}
