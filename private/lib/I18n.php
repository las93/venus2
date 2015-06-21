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
namespace Venus\lib;

use \Apollina\I18n as CoreI18n;

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
class I18n extends CoreI18n
{
    /**
     * constructor
     * 
     * @access public
     * @return \Venus\lib\I18n
     */
    public function __construct()
    {
        $this->setI18nDirectory(__DIR__.DIRECTORY_SEPARATOR.I18N_DIRECTORY)
             ->setI18nDomain(I18N_DOMAIN)
             ->setIntermediaiteDirectory(DIRECTORY_SEPARATOR.'LC_MESSAGES'.DIRECTORY_SEPARATOR);    
    }
}
