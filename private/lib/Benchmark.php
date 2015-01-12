<?php

/**
 * Manage Benchmark
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

use \Venus\lib\Debug as Debug;
use \Venus\lib\Log\LoggerAwareInterface as LoggerAwareInterface;
use \Venus\lib\Log\LoggerInterface as LoggerInterface;

/**
 * This class manage the Benchmark
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
 * @tutorial	$oBenchmark = new \Venus\lib\Benchmark;
 * 				echo $oBenchmark->getUrl('css/style.css');
 */
class Benchmark implements LoggerAwareInterface
{
	/**
	 * start Benchmark
	 *
	 * @access private
	 * @var    float
	 */
	private static $_fStart = 0;
	
	/**
	 * start Benchmark
	 *
	 * @access private
	 * @var    \Venus\lib\Debug
	 */
	private $_oLogger;

	/**
	 * assign a variable for the Benchmark
	 *
	 * @access public
	 * @param  string $sUrl url to get
	 * @return \Venus\lib\Benchmark
	 */
	public static function start()
	{
		self::$_fStart = microtime(true);
	}

	/**
	 * assign a variable for the Benchmark
	 *
	 * @access public
	 * @param  string $sUrl url to get
	 * @return \Venus\lib\Benchmark
	 */
	public static function getPoint()
	{
		return microtime(true) - self::$_fStart;
	}

	/**
	 * assign a variable for the Benchmark
	 *
	 * @access public
	 * @param  string $sName name of point
	 * @return \Venus\lib\Benchmark
	 */
	public static function setPointInLog($sName = 'default')
	{
	    $oLogger = new Debug();
	    $this->setLogger($oLogger);
	    
	    $this->getLogger()
	         ->log('BENCHMARK: Time at this point '.(microtime(true) - self::$_fStart).' - '.$sName);
	}
	
	/**
	 * Sets a logger instance on the object
	 *
	 * @access public
	 * @param  \Venus\lib\Debug $logger
	 * @return null
	 */
	public function setLogger(LoggerInterface $logger)
	{
	    if ($this->_oLogger === null) { $this->_oLogger = $logger; }
	}

	/**
	 * get the logger instance on the object
	 *
	 * @param LoggerInterface $logger
	 * @return \Venus\lib\Debug
	 */
	public function getLogger()
	{
	   return $this->_oLogger;
	}
}
