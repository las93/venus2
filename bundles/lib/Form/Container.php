<?php

/**
 * Container of Form lib
 *
 * @category  	Venus
 * @package		Venus\lib\Form
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
namespace Venus\lib\Form;

use \Attila\lib\Entity  as LibEntity;
use \Venus\lib\Form     as Form;

/**
 * Container of Form lib
 *
 * @category  	Venus
 * @package		Venus\lib\Form
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
class Container
{
	/**
	 * complete view
	 *
	 * @access private
	 * @var    string
	 */
	private $_sView = null;
	
	/**
	 * form library with its entity
	 *
	 * @access private
	 * @var    Form
	 */
	private $_oForm = null;
	
	/**
	 * Block the save in the entity if you don't call handleRequest
	 *
	 * @access private
	 * @var    bool
	 */
	private $_bHandleRequestActivate = false;
	
	/**
	 * Request of the formular
	 *
	 * @access private
	 * @var    array
	 */
	private $_aRequest = null;

	/**
	 * get the Value
	 *
	 * @access public
	 * @return object
	 */
	public function createView()
	{
	    $oView = new \stdClass;
	    $oView->form = $this->_sView;
	    $oView->form_start = $this->getFormInObject()->start;
	    $oView->form_end = $this->getFormInObject()->end;
	    $oView->form_row = $this->getFormInObject()->form;
	    
		return $oView;
	}

	/**
	 * set the Value
	 *
	 * @access public
	 * @param  string $sView Display of form;
	 * @return \Venus\lib\Form\Container
	 */
	public function setView($sView)
	{
		$this->_sView = $sView;
		return $this;
	}

	/**
	 * handle the request to do many actions on it
	 *
	 * @access public
	 * @param  array $aRequest request like $_POST
	 * @return bool
	 */
	public function handleRequest($aRequest)
	{
	    // Validation
	    foreach ($this->_oForm->_aElement as $sKey => $sValue) {
	    
	        if (!$sValue->validate($aRequest[$sValue->getName()])) {
	            
	            return false;
	        }
	    }
	    
	    // Save
		if ($this->_oForm->_iIdEntity > 0 && $this->_oForm->_sSynchronizeEntity !== null && count($aRequest) > 0) {
		
		    $sModelName = str_replace('Entity', 'Model', $this->_oForm->_sSynchronizeEntity);
		    $oModel = new $sModelName;
		
		    $oEntity = new $this->_oForm->_sSynchronizeEntity;
		    $sPrimaryKey = LibEntity::getPrimaryKeyNameWithoutMapping($oEntity);
		    $sMethodName = 'set_'.$sPrimaryKey;
		
		    call_user_func_array(array(&$oEntity, $sMethodName), array($this->_oForm->_iIdEntity));
		
		    foreach ($this->_oForm->_aElement as $sKey => $sValue) {
		
		        $sMethodName = 'set_'.$sValue->getName().'';
		        call_user_func_array(array(&$oEntity, $sMethodName), array($aRequest[$sValue->getName()]));
		    }
		
		    $oEntity->save();
		}
		else if ($this->_oForm->_sSynchronizeEntity !== null && isset($aRequest) && count($aRequest) > 0) {
		
		    $oEntity = new $this->_oForm->_sSynchronizeEntity;
		
		    foreach ($this->_oForm->_aElement as $sKey => $sValue) {
		
		        $sMethodName = 'set_'.$sValue->getName().'';
		        call_user_func_array(array(&$oEntity, $sMethodName), array($aRequest[$sValue->getName()]));
		    }
		
		    $this->_oForm->_iIdEntityCreated = $oEntity->save();
		}
		
		$this->_bHandleRequestActivate = true;
		$this->_aRequest = $aRequest;
		return true;
	}

	/**
	 * set Form lib with its entity
	 *
	 * @access public
	 * @param  Form $oForm request like $_POST
	 * @return \Venus\lib\Form\Container
	 */
	public function setForm(Form $oForm)
	{
		$this->_oForm = $oForm;
		return $this;
	}

	/**
	 * if this form is validate and save
	 *
	 * @access public
	 * @return boolean
	 */
	public function isValid()
	{
		if ($this->_bHandleRequestActivate === true) { return true; }
		else { return false; }
	}

	/**
	 * if this form is validate and save
	 *
	 * @access public
	 * @return boolean
	 */
	public function isSubmitted()
	{
	    if (isset($_POST['validform'.$this->_oForm->_iFormNumber]) && $_POST['validform'.$this->_oForm->_iFormNumber] == 1) { 
	        
	        return true;
	    }
		else { 
		    
		    return false;
		}
	}

	/**
	 * if this form is validate and save
	 * 
	 * @access public
	 * @param  string $sElementName element name what we want test the click
	 * @return boolean
	 */
	public function isClicked($sElementName)
	{
	    if (isset($_POST[$sElementName]) && $_POST[$sElementName]) { return true; }
		else { return false; }
	}
}
