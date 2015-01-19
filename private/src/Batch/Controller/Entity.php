<?php

/**
 * Batch that create entity
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
 * 				php launch.php scaffolding -p [portal]
 * 				-p [portal] => it's the name where you want add your entities and models
 * 				-r [rewrite] => if we force rewrite file
 * 					by default, it's Batch
 */
namespace Venus\src\Batch\Controller;

use \Venus\core\Config as Config;
use \Attila\Batch\Entity as Entity;
use \Venus\src\Batch\common\Controller as Controller;

/**
 * Batch that create entity
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
class Entity extends Controller
{
	/**
	 * run the batch to create entity
	 * @tutorial launch.php scaffolding
	 *
	 * @access public
	 * @param  array $aOptions options of script
	 * @param  string $sRewrite rewrite or not the file (no/yes)
	 * @return void
	 */

	public function runScaffolding(array $aOptions = array())
	{
	    if (isset($aOptions['p'])) { $sPortail = $aOptions['p']; }
	    else { $sPortail = 'Batch'; }
	    
	    $aOptions['b'] = json_encode(Config::get('Db', $aOptions['p']));
	    
	    $oBatch = new Entity;
	    $oBatch->runScaffolding($aOptions);
	}
}
