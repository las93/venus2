<?php

/**
 * Manage Form
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
 * @tutorial    == in the controller:
 *
 * 				$this->form
 * 					 ->add('task', 'text')
 *					 ->add('dueDate', 'date')
 *					 ->add('save', 'submit');
 *
 *				$this->view
 *					 ->assign('form', $this->form->getForm())
 *					 ->display();
 *
 *				in the template:
 *
 *				{$form}
 *
 *				== if you want test if the form is validated, you could do that:
 *
 *				if ($this->form->isValid()) { ... } // after the form definition
 *
 *				== check if the button is clicked:
 *
 *				if ($this->form->get('save')->isClicked()) { ... }
 */
namespace Venus\lib;

use \Venus\lib\Entity as LibEntity;
use \Venus\lib\Form\Checkbox as Checkbox;
use \Venus\lib\Form\Label as Label;
use \Venus\lib\Form\Input as Input;
use \Venus\lib\Form\Radio as Radio;
use \Venus\lib\Form\Select as Select;
use \Venus\lib\Form\Textarea as Textarea;

/**
 * This class manage the Form
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
class Form
{
	/**
	 * Elements of the form
	 *
	 *  @access private
	 *  @var    array
	 */
	private $_aElement = array();

	/**
	 * Increment for form
	 *
	 *  @access private
	 *  @var    int
	 */
	private static $_iFormIncrement = 0;

	/**
	 * number of form
	 *
	 *  @access private
	 *  @var    int
	 */
	private $_iFormNumber = 0;

	/**
	 * Separator between fields of form
	 *
	 *  @access private
	 *  @var    string
	 */
	private $_sSeparator = '<br/>';

	/**
	 * The entity to save with the formular
	 *
	 *  @access private
	 *  @var    string
	 */
	private $_sSynchronizeEntity = null;

	/**
	 * The id of entity
	 *
	 *  @access private
	 *  @var    int
	 */
	private $_iIdEntity = null;

	/**
	 * The entity to save with the formular
	 *
	 *  @access private
	 *  @var    int
	 */
	private $_iIdEntityCreated = null;

	/**
	 * constructor that it increment (static) for all use
	 *
	 * @access public
	 * @return \Venus\lib\Form
	 */
	public function __construct()
	{
		self::$_iFormIncrement++;
		$this->_iFormNumber = self::$_iFormIncrement;
	}

	/**
	 * add an element in the form
	 *
	 * @access public
	 * @param  string $sName name
	 * @param  string $sType type of field
	 * @param  string $sLabel label of field
	 * @param  mixed $mValue value of field
	 * @parma  mixed $mOptions options (for select)
	 * @return \Venus\lib\Form
	 */
	public function add($sName, $sType, $sLabel = null, $mValue = null, $mOptions = null)
	{
		if ($sType === 'text' || $sType === 'submit' || $sType === 'password' || $sType === 'file') {

			$this->_aElement[$sName] = new Input($sName, $sType, $sLabel, $mValue);
		}
		elseif ($sType === 'textarea') {

			$this->_aElement[$sName] = new Textarea($sName, $sLabel, $mValue);
		}
		else  if ($sType === 'select') {

			$this->_aElement[$sName] = new Select($sName, $mOptions, $sLabel, $mValue);
		}
		else  if ($sType === 'label') {

			$this->_aElement[$sName] = new Label($sName);
		}
		else  if ($sType === 'list_checkbox') {

			$i = 0;
			
			$this->_aElement[$sName.'_'.$i++] = new Label($sLabel);
			
			foreach ($mValue as $mKey => $sValue) {
			
				$this->_aElement[$sName.'_'.$i++] = new Checkbox($sName, $sValue, $mKey, $mOptions);
			}
		}
		else  if ($sType === 'checkbox') {

			$this->_aElement[$sName] = new Checkbox($sName, $sLabel, $mValue, $mOptions);
		}
		else  if ($sType === 'radio') {

			$this->_aElement[$sName.rand(100000,999999)] = new Radio($sName, $sLabel, $mValue, $mOptions);
		}
		else  if ($sType === 'date') {

			$aDay = array();

			for ($i = 1 ; $i <= 31 ; $i++) {

				if ($i < 10) { $aDay['0'.$i] = '0'.$i; }
				else { $aDay[$i] = $i; }
			}

			$this->_aElement[$sName.'_day'] = new Select($sName, $aDay);

			$aMonth = array(
				'01' => 'Jan',
				'02' => 'Feb',
				'03' => 'Mar',
				'04' => 'Apr',
				'05' => 'May',
				'06' => 'Jun',
				'07' => 'Jui',
				'08' => 'Aug',
				'09' => 'Sep',
				'10' => 'Oct',
				'11' => 'Nov',
				'12' => 'Dec',
			);

			$this->_aElement[$sName.'_month'] = new Select($sName, $aMonth);

			$aYear = array();

			for ($i = 1900 ; $i <= 2013 ; $i++) {

				$aYear[$i] = $i;
			}

			$this->_aElement[$sName.'_year'] = new Select($sName, $aMonth);
		}

		return $this;
	}

	/**
	 * get id entity created by the formular
	 *
	 * @access public
	 * @return int
	 */
	public function getIdEntityCreated()
	{	
		return $this->_iIdEntityCreated;
	}

	/**
	 * get global form
	 *
	 * @access public
	 * @return string
	 */
	public function getForm()
	{
		if ($this->_iIdEntity > 0 && $this->_sSynchronizeEntity !== null && count($_POST) > 0) {

			$sModelName = str_replace('Entity', 'Model', $this->_sSynchronizeEntity);
			$oModel = new $sModelName;
				
			$oEntity = new $this->_sSynchronizeEntity;
			$sPrimaryKey = LibEntity::getPrimaryKeyNameWithoutMapping($oEntity);
			$sMethodName = 'set_'.$sPrimaryKey;

			call_user_func_array(array(&$oEntity, $sMethodName), array($this->_iIdEntity));

			foreach ($this->_aElement as $sKey => $sValue) {
			
				$sMethodName = 'set_'.$sValue->getName().'';
				call_user_func_array(array(&$oEntity, $sMethodName), array($_POST[$sValue->getName()]));
			}
				
			$oEntity->save();
		}
		else if ($this->_sSynchronizeEntity !== null && isset($_POST) && count($_POST) > 0) {
			
			$oEntity = new $this->_sSynchronizeEntity;
			
			foreach ($this->_aElement as $sKey => $sValue) {
				
				$sMethodName = 'set_'.$sValue->getName().'';
				call_user_func_array(array(&$oEntity, $sMethodName), array($_POST[$sValue->getName()]));
			}
			
			$this->_iIdEntityCreated = $oEntity->save();
		}
		else if ($this->_iIdEntity > 0 && $this->_sSynchronizeEntity !== null && count($_POST) < 1) {

			$sModelName = str_replace('Entity', 'Model', $this->_sSynchronizeEntity);
			$oModel = new $sModelName;
			
			$oEntity = new $this->_sSynchronizeEntity;
			$sPrimaryKey = LibEntity::getPrimaryKeyNameWithoutMapping($oEntity);
			$sMethodName = 'findOneBy'.$sPrimaryKey;
			$oCompleteEntity = call_user_func_array(array(&$oModel, $sMethodName), array($this->_iIdEntity));

			if (is_object($oCompleteEntity)) {

				foreach ($this->_aElement as $sKey => $sValue) {
	
					if ($sValue instanceof \Venus\lib\Form\Radio) { 
						
						$sExKey = $sKey;
						$sKey = substr($sKey, 0, -6);
					}
					
					$sMethodNameInEntity = 'get_'.$sKey;
					$mValue = $oCompleteEntity->$sMethodNameInEntity();

					if ($sValue instanceof \Venus\lib\Form\Radio && method_exists($this->_aElement[$sExKey], 'setValueChecked')) {
						
						$this->_aElement[$sExKey]->setValueChecked($mValue);
					}
					else if (isset($mValue) && method_exists($this->_aElement[$sKey], 'setValue')) { 
						
						$this->_aElement[$sKey]->setValue($mValue); 
					}
				}
			}			
		}
		
		$sFormContent = '<form name="form'.$this->_iFormNumber.'" method="post"><input type="hidden" value="1" name="validform'.$this->_iFormNumber.'">';

		foreach ($this->_aElement as $sKey => $sValue) {

			$sFormContent .= $sValue->fetch().$this->_sSeparator;
		}

		$sFormContent .= '</form>';

		return $sFormContent;
	}

	/**
	 * if this form is validate or not
	 *
	 * @access public
	 * @return boolean
	 */
	public function isValid()
	{
		if (isset($_POST['validform'.$this->_iFormNumber]) && $_POST['validform'.$this->_iFormNumber] == 1) { return true; }
		else { return false; }
	}

	/**
	 * get an element of formular
	 *
	 * @access public
	 * @param  string $sName name
	 * @return object
	 */
	public function get($sName)
	{
		return $this->_aElement[$sName];
	}

	/**
	 * get the form separator
	 *
	 * @access public
	 * @return string
	 */
	public function getSeparator()
	{
		return $this->_sSeparator;
	}

	/**
	 * set the form separator
	 *
	 * @access public
	 * @param  string $sSeparator separator between the fields
	 * @return \Venus\lib\Form
	 */
	public function setSeparator($sSeparator)
	{
		$this->_sSeparator = $sSeparator;
		return $this;
	}

	/**
	 * set the entity to synchronize with the formular
	 *
	 * @access public
	 * @param  string $sSeparator separator between the fields
	 * @param  int $iId id of the primary key
	 * @return \Venus\lib\Form
	 */
	public function synchronizeEntity($sSynchronizeEntity, $iId = null)
	{
		if ($iId !== null) { $this->_iIdEntity = $iId; }
			
		$this->_sSynchronizeEntity = $sSynchronizeEntity;
		return $this;
	}
}
