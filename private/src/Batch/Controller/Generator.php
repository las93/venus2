<?php

/**
 * Batch that generate files and folders
 *
 * @category  	src
 * @package   	src\Batch\Controller
 * @author    	Judicaël Paquet <paquet.judicael@iscreenway.com>
 * @copyright 	Copyright (c) 2013-2014 iScreenway FR/VN Inc. (http://www.iscreenway.com)
 * @license   	http://www.iscreenway.com/framework/licence.php Tout droit réservé à http://www.iscreenway.com
 * @version   	Release: 1.0.0
 * @filesource	http://www.iscreenway.com/framework/download.php
 * @link      	http://www.iscreenway.com
 * @since     	1.0
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
 * @author    	Judicaël Paquet <paquet.judicael@iscreenway.com>
 * @copyright 	Copyright (c) 2013-2014 iScreenway FR/VN Inc. (http://www.iscreenway.com)
 * @license   	http://www.iscreenway.com/framework/licence.php Tout droit réservé à http://www.iscreenway.com
 * @version   	Release: 1.0.0
 * @filesource	http://www.iscreenway.com/framework/download.php
 * @link      	http://www.iscreenway.com
 * @since     	1.0
 */

class Generator extends Controller {

	/**
	 * run the batch to create a project in this framework
	 * @tutorial launch.php create_project
	 *
	 * @access public
	 * @param  string $sPortail name of the portail that you would create
	 * @return void
	 */

	public function create(array $aOptions = array()) {

		/**
		 * option -p [portail]
		 */

		if (isset($aOptions['p'])) { $sPortail = $aOptions['p']; }
		else { $sPortail = 'Batch'; }

		if (!preg_match('/^[a-zA-Z0-9]+$/', $sPortail)) {

			echo 'You can`t create this portail :'.$sPortail.'! The name must containt just letters and numbers.';
			throw new \Exception('You can`t create this portail :'.$sPortail.'! The name must containt just letters and numbers.');
		}

		$sActualDirectory = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__);
		$sPrivatePath = str_replace('/Batch/Controller', '', $sActualDirectory).DIRECTORY_SEPARATOR;
		$sPublicPath = str_replace('/private/src/Batch/Controller', DIRECTORY_SEPARATOR.'public', $sActualDirectory).DIRECTORY_SEPARATOR;
		$sPublicPath = str_replace('/', DIRECTORY_SEPARATOR, $sPublicPath);

		if (!is_writable($sPublicPath)) {

			echo 'The batch can`t create public folders for '.$sPortail.'! Please check the rights.';
			throw new \Exception('The batch can`t create public folders for '.$sPortail.'! Please check the rights.');
		}
		else {

			mkdir($sPublicPath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'css', 0777, true);
			mkdir($sPublicPath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'js', 0777, true);
			mkdir($sPublicPath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'img', 0777, true);

			$sContentFile = '<?php

/**
 * bootstrap of the framework
 *
 * @author    	'.AUTHOR.'
 * @copyright 	'.COPYRIGHT.'
 * @license   	'.LICENCE.'
 * @version   	Release: '.VERSION.'
 * @filesource	'.FILESOURCE.'
 * @link      	'.LINK.'
 * @since     	1.0
 */

const PORTAIL = \''.$sPortail.'\';

set_include_path(get_include_path().PATH_SEPARATOR.str_replace(\'public\'.DIRECTORY_SEPARATOR.PORTAIL, \'private\', __DIR__));

require \'conf/AutoLoad.php\';

\Venus\lib\Debug::activateDebug();

$oRouter = new \Venus\core\Router();
$oRouter->run();'."\n";

			file_put_contents($sPublicPath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'index.php', $sContentFile);

			$sContentFile = 'RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ /index.php [NC,L]';

			file_put_contents($sPublicPath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'.htaccess', $sContentFile);
		}

		if (!is_writable($sPrivatePath)) {

			echo 'The batch can`t create private folders for '.$sPortail.'! Please check the rights.';
			throw new \Exception('The batch can`t create private folders for '.$sPortail.'! Please check the rights.');
		}
		else {

			mkdir($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'Controller', 0777, true);
			mkdir($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'Entity', 0777, true);
			mkdir($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'Model', 0777, true);
			mkdir($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'View', 0777, true);
			mkdir($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'conf', 0777, true);
			mkdir($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'common', 0777, true);

			$sContent = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Controller.php');
			$sContent = str_replace('Batch', $sPortail, $sContent);
			file_put_contents($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Controller.php', $sContent);

			$sContent = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Model.php');
			$sContent = str_replace('Batch', $sPortail, $sContent);
			file_put_contents($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Model.php', $sContent);

			$sContent = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Entity.php');
			$sContent = str_replace('Batch', $sPortail, $sContent);
			file_put_contents($sPrivatePath.DIRECTORY_SEPARATOR.$sPortail.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Entity.php', $sContent);
		}

		echo 'The project '.$sPortail.' is created!';
	}
}
