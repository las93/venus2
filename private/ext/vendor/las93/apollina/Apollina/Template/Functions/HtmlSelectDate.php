<?php

/**
 * Manage Template
 *
 * @category  	Apollina
 * @package     Apollina\Template\Functions
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 3.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	3.0.0
 */
namespace Apollina\Template\Functions;

/**
 * This class manage the Template
 *
 * @category  	Apollina
 * @package     Apollina\Template\Functions
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 3.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	3.0.0
 */
class HtmlSelectDate 
{
	/**
	 * run before
	 *
	 * @access public
	 * @param  array $aParams parameters
	 * @return \Apollina\Template\HtmlSelectDate
	 */
	public function replaceBy($aParams = array()) 
	{
		$bDisplayName = true;

		if (isset($aParams['display_days'])) { $bDisplayName = $aParams['display_days']; }

		$sReturn = '
		<select name="Date_Month">
			<option value="1">January</option><option value="2">February</option><option value="3">March</option>
			<option value="4">April</option><option value="5">May</option><option value="6">june</option><option value="7">Juillet</option>
			<option value="8">August</option><option value="9">September</option><option value="10">October</option>
			<option value="11">November</option><option value="12">December</option>
		</select>
		';

		if ($bDisplayName === true) {

			$sReturn .= '
			<select name="Date_Day">
				<option value="1">01</option>
				<option value="2">02</option>
				<option value="3">03</option>
				<option value="4">04</option>
				<option value="5">05</option>
				<option value="6">06</option>
				<option value="7">07</option>
				<option value="8">08</option>
				<option value="9">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select>
			';
		}

		$sReturn .= '
		<select name="Date_Year">
		';

  		for ($i = 1900 ; $i <= 2013 ; $i++) {

  			$sReturn .= '<option value="'.$i.'">'.$i.'</option>';
  		}

  		$sReturn .= '</select>';

		return $sReturn;
	}
}
