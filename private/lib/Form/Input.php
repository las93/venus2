<?php

/**
 * Manage Form
 *
 * @category  	lib
 * @package		lib\Form
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
namespace Venus\lib\Form;

/**
 * This class manage the Form
 *
 * @category  	lib
 * @package		lib\Form
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	1.0
 */
class Input extends Common
{
	/**
	 * the name of element
	 *
	 * @access private
	 * @var    string
	 */
	private $_sType = null;
	
	/**
	 * the label of element
	 *
	 * @access private
	 * @var    string
	 */
	private $_sLabel = null;
	
	/**
	 * the value of element
	 *
	 * @access private
	 * @var    string
	 */
	private $_sValue = null;

	/**
	 * constructor that it increment (static) for all use
	 *
	 * @access public
	 * @param  string $sName name
	 * @param  string $sType type of input
	 * @param  string $sLabel label of input
	 * @param  string $sValue value of input
	 * @return \Venus\lib\Form\Input
	 */
	public function __construct($sName, $sType, $sLabel = null, $sValue = null)
	{
		$this->setName($sName);
		$this->setType($sType);
		$this->setValue($sValue);

		if ($sLabel !== null) { $this->setLabel($sLabel); }
		else { $this->setLabel($sName); }
	}

	/**
	 * get the type
	 *
	 * @access public
	 * @return string
	 */
	public function getType()
	{
		return $this->_sType;
	}

	/**
	 * set the type
	 *
	 * @access public
	 * @param  string $sType type of input;
	 * @return \Venus\lib\Form\Input
	 */
	public function setType($sType)
	{
		$this->_sType = $sType;
		return $this;
	}

	/**
	 * get the Value
	 *
	 * @access public
	 * @return string
	 */
	public function getValue()
	{
		return $this->_sValue;
	}

	/**
	 * set the Value
	 *
	 * @access public
	 * @param  string $sValue Value of input;
	 * @return \Venus\lib\Form\Input
	 */
	public function setValue($sValue)
	{
		$this->_sValue = $sValue;
		return $this;
	}

	/**
	 * get the Label
	 *
	 * @access public
	 * @return string
	 */
	public function getLabel()
	{
		return $this->_sLabel;
	}

	/**
	 * set the Label
	 *
	 * @access public
	 * @param  string $sLabel Label of input;
	 * @return \Venus\lib\Form\Input
	 */
	public function setLabel($sLabel)
	{
		$this->_sLabel = $sLabel;
		return $this;
	}

	/**
	 * if the button is clicked
	 *
	 * @access public
	 * @param  string $sType type of input;
	 * @return bool
	 */
	public function isClicked($sType)
	{
		if ($this->getType() === 'submit' || $this->getType() === 'button') {

			if (isset($_POST[$this->getName()])) { return true; }
		}

		return false;
	}

	/**
	 * get the <html>
	 *
	 * @access public
	 * @return string
	 */
	public function fetch()
	{
		$sContent = '';

		if ($this->getType() === 'text' || $this->getType() === 'password' || $this->getType() === 'file') {

			$sContent .= '<label>'.$this->getLabel().'</label> ';
		}

		$sContent .= '<input type="'.$this->getType().'" name="'.$this->getName().'"';
		
		if ($this->getValue() !== null) { $sContent .= ' value="'.$this->getValue().'"'; }
		
		$sContent .= '/>';

		return $sContent;
	}
}
