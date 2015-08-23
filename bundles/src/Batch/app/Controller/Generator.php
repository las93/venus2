<?php

/**
 * Batch that generate files and folders
 *
 * @category  	src
 * @package   	src\Batch\Controller
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 2.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	2.0.0
 *
 * @tutorial    You could launch this Batch in /private/
 * 				php launch.php create_project -p [portal]
 * 				-p [portal] => it's the name where you want add your entities and models
 * 					by default, it's Batch
 */
namespace Venus\src\Batch\Controller;

use \Venus\src\Batch\common\Controller as Controller;

/**
 * Batch that generate files and folders
 *
 * @category  	src
 * @package   	src\Batch\Controller
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 2.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	2.0.0
 */
class Generator extends Controller
{
	/**
	 * run the batch to create a project in this framework
	 * @tutorial launch.php create_project
	 *
	 * @access public
	 * @param  string $sPortal name of the portail that you would create
	 * @return void
	 */
	public function create(array $aOptions = array())
	{
		/**
		 * option -p [portail]
		 */
		if (isset($aOptions['p'])) { $sPortal = $aOptions['p']; }
		else { $sPortal = 'Batch'; }

		if (!preg_match('/^[a-zA-Z0-9]+$/', $sPortal)) {

			echo 'You can`t create this portail :'.$sPortal.'! The name must containt just letters and numbers.';
			throw new \Exception('You can`t create this portail :'.$sPortal.'! The name must containt just letters and numbers.');
		}

		$sActualDirectory = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__);
		$sPrivatePath = str_replace('/Batch/Controller', DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'app', $sActualDirectory).DIRECTORY_SEPARATOR;
		$sPublicPath = str_replace('/Batch/Controller', DIRECTORY_SEPARATOR.$sPortal.DIRECTORY_SEPARATOR.'public', $sActualDirectory).DIRECTORY_SEPARATOR;

		if (!is_writable($sPublicPath)) {

			echo 'The batch can`t create public folders for '.$sPortal.'! Please check the rights.';
			throw new \Exception('The batch can`t create public folders for '.$sPortal.'! Please check the rights.');
		}
		else {

			if (!file_exists($sPrivatePath.'Controller')) {

				mkdir($sPublicPath . 'css', 0777, true);
				mkdir($sPublicPath . 'js', 0777, true);
				mkdir($sPublicPath . 'img', 0777, true);
			}
			else {

				echo 'The Project (public part) ' . $sPrivatePath . " exists\n";
			}
		}

		if (!is_writable($sPrivatePath)) {

			echo 'The batch can`t create private folders for '.$sPortal.'! Please check the rights.';
			throw new \Exception('The batch can`t create private folders for '.$sPortal.'! Please check the rights.');
		}
		else {

			if (!file_exists($sPrivatePath.'Controller')) {

				mkdir($sPrivatePath . 'Controller', 0777, true);
				mkdir($sPrivatePath . 'Entity', 0777, true);
				mkdir($sPrivatePath . 'Model', 0777, true);
				mkdir($sPrivatePath . 'View', 0777, true);
				mkdir($sPrivatePath . 'conf', 0777, true);
				mkdir($sPrivatePath . 'common', 0777, true);
			}
			else {

				echo 'The Project (private part) ' . $sPrivatePath . " exists\n";
			}

			$sContent = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Controller.php');
			$sContent = str_replace('Batch', $sPortal, $sContent);
			file_put_contents($sPrivatePath.'common'.DIRECTORY_SEPARATOR.'Controller.php', $sContent);

			$sContent = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Model.php');
			$sContent = str_replace('Batch', $sPortal, $sContent);
			file_put_contents($sPrivatePath.'common'.DIRECTORY_SEPARATOR.'Model.php', $sContent);

			$sContent = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Entity.php');
			$sContent = str_replace('Batch', $sPortal, $sContent);
			file_put_contents($sPrivatePath.'common'.DIRECTORY_SEPARATOR.'Entity.php', $sContent);
		}

		echo 'The project '.$sPortal.' is created!';
	}
}
