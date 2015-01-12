<?php

/**
 * Error Manager
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

use \Venus\Exception as Exception;

/**
 * Error Manager
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
class Error
{
	/**
	 * get a Erroruration
	 *
	 * @access public
	 * @param  string sName name of the Erroruration
	 * @return void
	 */
	public static function activateDebug()
	{
		error_reporting(E_ALL);
		ini_set('display_error', 0);
		set_error_handler(array('\Venus\core\Error', 'setErrorHandler'));
		set_exception_handler(array('\Venus\core\Error', 'setExceptionHandler'));
		register_shutdown_function(array('\Venus\core\Error', 'setShudownHandler'));
	}

	/**
	 * get file content and merge if not exists
	 *
	 * @access private
	 * @param  int $iNumber number of error
	 * @param  string $sMessage message
	 * @param  string $sFile file
	 * @param  int $iLine number of line
	 * @return array
	 */
	public static function setErrorHandler($iNumber, $sMessage, $sFile, $iLine)
	{
		self::showError(array('code' => $iNumber, 'message' => $sMessage, 'line' => $iLine, 'file' => $sFile));
		self::showDebugBacktrace(debug_backtrace());
	}

	/**
	 * get file content and merge if not exists
	 *
	 * @access private
	 * @param  string $sFileToMerge file to get
	 * @param  array $aBase base
	 * @return array
	 */
	public static function setExceptionHandler(Exception $e)
	{
		self::showDebugBacktrace(debug_backtrace());
	}

	/**
	 * get file content and merge if not exists
	 *
	 * @access private
	 * @return array
	 */
	public static function setShudownHandler()
	{
	    $aError = error_get_last();

	    if (($aError['type'] === E_ERROR) || ($aError['type'] === E_USER_ERROR)) {

	    	self::setErrorHandler($aError['type'], $aError['message'], $aError['file'], $aError['line']);
	    }
	}

	/**
	 * get file content and merge if not exists
	 *
	 * @access private
	 * @return array
	 */
	public static function showDebugBacktrace(array $aDebugbacktrace)
	{
		foreach ($aDebugbacktrace as $iKey => $aOne) {

			self::showDebug($aOne);
		}
	}

	/**
	 * get file content and merge if not exists
	 *
	 * @access private
	 * @return array
	 */
	private static function showDebug($mDebug)
	{
		if (is_object($mDebug) && !$mDebug instanceof \StdClass) {

			$aDebug = array();
			$aDebug["line"] = $mDebug->getLine();
			$aDebug["file"] = $mDebug->getFile();
			//$aDebug["class"] = $mDebug->getTrace();
			//$aDebug["function"] = $mDebug->function;
			$aDebug["args"] = $mDebug->getTrace();
			$aDebug["message"] = $mDebug->getMessage();
		}
		else if (is_object($mDebug) && $mDebug instanceof \StdClass) {

			var_dump($mDebug);
		}
		else { $aDebug = $mDebug; }

		echo '<table style="background-color:orange" cellpadding="10" cellspacing="10" width="100%"><tr><td style="background-color:yellow;">';

		if (isset($aDebug["line"])) { echo ' line '.$aDebug["line"].' ';}

		if (isset($aDebug["file"])) { echo ' in file '.$aDebug["file"].'<br/>'; }

		if (isset($aDebug["class"])) { echo ' class '.$aDebug["class"].' '; }

		if (isset($aDebug["function"])) {  echo ' function '.$aDebug["function"].' with arguments '; }

		if (isset($aDebug["args"])) {

			foreach ($aDebug["args"] as $iKey2 => $aOne2) {

				//if (is_object($aOne2) || (is_array($aOne2) && isset($aOne2['file']))) { self::showDebug($aOne2);  }
				//else { echo '<pre>'.print_r($aOne2, true).'</pre>'; }
			}
		}

		echo '</td></tr></table>';
	}

	/**
	 * get file content and merge if not exists
	 *
	 * @access private
	 * @return array
	 */
	private static function showError($aDebug)
	{
		echo '<table style="background-color:red" cellpadding="10" cellspacing="10" width="100%"><tr><td style="background-color:orange;">';
		echo ' line '.$aDebug["line"].'&nbsp;';
		echo ' in file '.$aDebug["file"].'<br/>';
		echo ' code '.$aDebug["code"].'&nbsp;';
		echo ' message '.$aDebug["message"];
		echo '</td></tr></table>';
	}
}
