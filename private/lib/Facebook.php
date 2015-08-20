<?php

/**
 * library of Facebook
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

use \Facebook as LibFacebook;
use \Venus\core\Exception as Exception;

/**
 * Controller to article
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
 * @help		http://thinkdiff.net/facebook/php-sdk-3-0-graph-api-base-facebook-connect-tutorial/
 */
class Facebook
{
	/**
	 * app id of Facebook
	 * @var string
	 */
	const APP_ID = FACEBOOK_APP_ID;

	/**
	 * app secret of Facebook
	 * @var string
	 */
	const APP_SECRET = FACEBOOK_APP_SECRET;

	/**
	 * app secret of Facebook
	 * @var string
	 */
	const BASE_URL = FACEBOOK_BASE_URL;

	/**
	 * app secret of Facebook
	 * @var array
	 */
	//private $_aScope = array('email','offline_access,publish_stream','user_birthday','user_location','user_work_history',
	//	'user_about_me','user_hometown', 'manage_pages');
	private $_aScope = array('email','user_birthday','user_location','user_work_history',
					'user_about_me','user_hometown');

	/**
	 * object Facebook of the SDK
	 * @var \Facebook
	 */
	private $_oFacebook = null;

	/**
	 * Constructor
	 *
	 * @access public
	 * @return object
	 */
	public function __construct()
	{
		$aConfig = array();
		$aConfig['appId'] = self::APP_ID;
		$aConfig['secret'] = self::APP_SECRET;

		$this->_oFacebook = new LibFacebook($aConfig);
	}

	/**
	 * get user
	 *
	 * @access public
	 * @return string
	 */
	public function getUser()
	{
		return $this->_oFacebook->getUser();
	}

	/**
	 * get Login/Logout Facebook
	 *
	 * @access public
	 * @return string
	 */
	public function getButton($sLabelName = 'Inscription par Facebook')
	{
		if ($this->_oFacebook->getUser()) {

			return '<a href="'.$this->_oFacebook->getLogoutUrl().'">'.$sLabelName.'</a>';
		}
		else {

			return '<a href="'.$this->_oFacebook->getLoginUrl(
				array(
					'scope' => implode(',', $this->_aScope),
					'redirect_uri' => self::BASE_URL
				)
			).'">'.$sLabelName.'</a>';
		}
	}

	/**
	 * set the scope - you could use addScope to add one element
	 *
	 * @access public
	 * @param  array $aScope
	 * @return \Venus\lib\Facebook
	 */
	public function setScope(array $aScope)
	{
		$this->_aScope = $aScope;
		return $this;
	}

	/**
	 * add one scope
	 *
	 * @access public
	 * @param  string $aScope
	 * @return \Venus\lib\Facebook
	 */
	public function addScope($sScope)
	{
		if (!is_string($sScope)) {

			throw new Exception(__FILE__.':'.__METHOD__.' : You must add a string!');
		}

		$this->_aScope[] = $sScope;
		return $this;
	}

	/**
	 * add one scope
	 *
	 * @access public
	 * @param  string $aScope
	 * @return object
	 */
	public function getUserInfo()
	{
		$sUser = $this->_oFacebook->getUser();
		return $this->_oFacebook->api('/'.$sUser);
	}

	/**
	 * gzet info by api graph
	 *
	 * @access public
	 * @param  string $sName name to call
	 * @return object
	 */
	public function getInfo($sName)
	{
		$sUser = $this->_oFacebook->getUser();

		try {

			return $this->_oFacebook->api('/'.$sUser.'/'.$sName);
		}
		catch(Exception $e) {

			throw new Exception(__FILE__.':'.__METHOD__.' : You can\'t ask: '.'/'.$sUser.'/'.$sName.' !');
		}
	}

	/**
	 * get info by FQL query
	 *
	 * @access public
	 * @param  string $sFql fql query
	 * @return object
	 */
	public function getInfoByFql($sFql)
	{
		$sUser = $this->_oFacebook->getUser();

		try {

			$aParam  =   array(
				'method' => 'fql.query',
				'query' => $sFql,
				'callback' => ''
			);

			return $this->_oFacebook->api($aParam);
		}
		catch(Exception $e) {

			throw new Exception(__FILE__.':'.__METHOD__.' : You can\'t ask: '.$sFql.' !');
		}
	}

	/**
	 * publish Wall Post
	 *
	 * @access public
	 * @param  string $sFql fql query
	 * @return object
	 */
	public function publishWallPost($sMessage, $sLink, $sImg, $sName, $sDescription)
	{
		$sUser = $this->_oFacebook->getUser();

		try {

			$this->_oFacebook->api('/'.$sUser.'/feed', 'post', array(
                    'message' => $sMessage,
                    'link'    => $sLink,
                    'picture' => $sImg,
                    'name'    => $sName,
                    'description'=> $sDescription
           		)
			);
		}
		catch(Exception $e) {

			throw new Exception(__FILE__.':'.__METHOD__.' : You can\'t ask: '.'/'.$sUser.'/feed'.' !');
		}
	}

	/**
	 * publish Wall Post
	 *
	 * @access public
	 * @param  string $sFql fql query
	 * @return object
	 */
	public function publishMyWallPost($sPageId, $sMessage, $sLink, $sImg, $sDescription)
	{
		$user = $this->_oFacebook->getUser();

		if ($user){

			try{

				$accounts = $this->_oFacebook->api('/me/accounts');

				echo '<pre>';
				print_r($accounts); /* on affiche les informations retournées */
			}
			catch (\Exception $e) {
				
				print_r($e);
				$user = null;
			}
		}

		$login_params = array(
			'scope' => 'manage_pages,publish_stream,offline_access' /* paramètres permettant de récupérer le token, offline_access permet d'utiliser le token même si vous n'êtes pas connecté directement (ex. : avec un cron) */
		);

  		$accessToken = $this->_oFacebook->getAccessToken();

		try {

			$this->_oFacebook->api('/'.$sPageId.'/feed', 'post', array(
					'token' => $accessToken,
					'message' => $sMessage,
					'link'    => $sLink,
					'picture' => $sImg,
					'description'=> $sDescription
				)
			);
		}
		catch(Exception $e) {

			var_dump($e);
			throw new Exception(__FILE__.':'.__METHOD__.' : You can\'t ask: '.'/'.$sPageId.'/feed'.' !');
		}
	}

	/**
	 * publish Wall Post
	 *
	 * @access public
	 * @param  int $iWidth width
	 * @param  int $iHeight height
	 * @return object
	 */
	public function getPicture($iWidth = 50, $iHeight = 50)
	{
		$oUser = $this->getUserInfo();
		$sUserName = $oUser['username'];
		return 'http://graph.facebook.com/'.$sUserName.'/picture?width='.$iWidth.'&height='.$iHeight;
	}
}
