<?php

/**
 * Manage Template
 *
 * @category  	Apollina
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 3.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	3.0.0.0
 */
namespace Apollina;

/**
 * This class manage the Template
 *
 * @category  	Apollina
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 3.0.0
 * @filesource	https://github.com/las93/venus2
 * @link      	https://github.com/las93
 * @since     	3.0.0.0
 */
class Template 
{
	/**
	 * version
	 *
	 * @var    int
	 */
	const VERSION = '3.0.0.0';

	/**
	 * Array of var to assign at the template
	 *
	 * @access private
	 * @var    array
	 */
	private $_aVar = array();

	/**
	 * Template name
	 *
	 * @access private
	 * @var    string
	 */
	private $_sTemplateName = '';

	/**
	 * Cache time
	 *
	 * @access private
	 * @var    int
	 */
	private $_iCacheTime = 3600;

	/**
	 * Caching
	 *
	 * @access private
	 * @var    int
	 */
	private $_iCaching = 0;

	/**
	 * Left delimiter
	 *
	 * @access private
	 * @var    string
	 */
	private $_sLeftDelimiter = '{literal}';

	/**
	 * Right delimiter
	 *
	 * @access private
	 * @var    string
	 */
	private $_sRightDelimiter = '{/literal}';

	/**
	 * Right delimiter
	 *
	 * @access private
	 * @var    \Apollina\Template
	 */
	private $_oTemplateLink = null;

	/**
	 * If the system detect mobile
	 *
	 * @access private
	 * @var    bool
	 */
	private $_bIsMobile = false;

	/**
	 * The base path of templates
	 *
	 * @access private
	 * @var    string
	 */
	private static $_sBasePath = '';

	/**
	 * The base path of templates
	 *
	 * @access private
	 * @var    string
	 */
	private static $_sCachePath = '';

	/**
	 * The render level
	 *
	 * @access private
	 * @var    int
	 */
	private static $_iRenderLevel = 5;
	
	/**
	 * constant to define the render level
	 * @var int
	 */
	const LEVEL_NO_RENDER = 0;
	const LEVEL_VIEW = 1;
	const LEVEL_LAYOUT = 2;

	/**
	 * If the tempalte is the layout
	 *
	 * @access private
	 * @var    bool
	 */
	private $_bIsLayout = false;

	/**
	 * If the tempalte is the layout
	 *
	 * @access private
	 * @var    array
	 */
	private static $_aDisableRenderLevel = array(1 => false, 2 => false);
	
	/**
	 * constructor of class
	 *
	 * @access public
	 * @param  string $sName name of the template
	 * @param  string $sCachePath cache of the cache
	 * @return \Apollina\Template
	 */
	public function __construct($sName = null, $sBasePathOfTemplate = null, $sCachePath = null, $bIsLayout = false) 
	{
	    $this->_bIsLayout = $bIsLayout;
	    
	    if ($sBasePathOfTemplate !== null) { self::$_sBasePath = $sBasePathOfTemplate; }

	    if ($sCachePath !== null) { self::$_sCachePath = $sCachePath; }
	    
	    if (class_exists('\Mobile_Detect')) {
	        
	        $oMobileDetect = new \Mobile_Detect;
	        $this->_bIsMobile = $oMobileDetect->isMobile();
	    }

		if ($this->_bIsMobile) {

			if ($sName && is_string($sName) && strstr($sName, '.tpl')) {

				$sMobileTpl = self::$_sBasePath.str_replace('.tpl', 'Mobile.tpl', $sName);
				if (file_exists($sMobileTpl)) { $sName = str_replace('.tpl', 'Mobile.tpl', $sName); }
			}
		}

		if ($sName !== null) { $this->_sTemplateName = $sName; }
	}

	/**
	 * caching templates
	 *
	 * @access public
	 * @param  int $iValue caching kind
	 * @return \Apollina\Template
	 * 
	 * @todo to use soon
	 */
	public function caching($iValue) 
	{
		$this->_iCaching = $iValue;
		return $this;
	}

	/**
	 * caching templates
	 *
	 * @access public
	 * @param  int $iValue caching kind
	 * @return \Apollina\Template
	 * 
	 * @todo to use soon
	 */
	public function time($iValue) 
	{
		$this->_iCacheTime = $iValue;
		return $this;
	}

	/**
	 * assign a variable for the template
	 *
	 * @access public
	 * @param  string $sName name of the variable
	 * @param  mixed $mValue value of the variable
	 * @return \Apollina\Template
	 */
	public function assign($sName, $mValue) 
	{
		$this->_aVar[$sName] = $mValue;
		return $this;
	}

	/**
	 * assign all variable for the template
	 *
	 * @access public
	 * @param  mixed $mValue value of the variable
	 * @return \Apollina\Template
	 */
	public function assignAll($mValue) 
	{
		$this->_aVar = $mValue;
		return $this;
	}

	/**
	 * get all assign variables
	 *
	 * @access public
	 * @return mixed
	 */
	public function getAllAssign() 
	{
		return $this->_aVar;
	}

	/**
	 * set a left delimiter
	 *
	 * @access public
	 * @param  string $sValue value of delimiter
	 * @return \Apollina\Template
	 */
	public function setLeftDelimiter($sValue) 
	{
		$this->_sLeftDelimiter = $sValue;
		return $this;
	}

	/**
	 * set a rigth delimiter
	 *
	 * @access public
	 * @param  string $sValue value of delimiter
	 * @return \Apollina\Template
	 */
	public function setRightDelimiter($sValue) 
	{
		$this->_sRightDelimiter = $sValue;
		return $this;
	}

	/**
	 * get a left delimiter
	 *
	 * @access public
	 * @return string
	 */
	public function getLeftDelimiter() 
	{
		return $this->_sLeftDelimiter;
	}

	/**
	 * get a rigth delimiter
	 *
	 * @access public
	 * @return string
	 */
	public function getRightDelimiter() 
	{
		return $this->_sRightDelimiter;
	}

	/**
	 * show the template
	 *
	 * @access public
	 * @param  string $sName name of the template
	 * @param  \Apollina\Template $oTemplate datas to add
	 * @return bool
	 */
	public function display($sName = null, \Apollina\Template $oTemplate = null) 
	{
		if ($oTemplate !== null) {

			if ($this->_oTemplateLink !== null) {

				$aVar = $this->getAllAssign();
				$aVar = array_merge($aVar, $this->_oTemplateLink->getAllAssign());
				$this->assignAll($aVar);
			}
		}

		$sTemplate = $this->fetch($sName);
		echo $sTemplate;
	}

	/**
	 * fetch the template
	 *
	 * @access public
	 * @param  string $sName name of the template
	 * @param  bool $bMainCall main call or not
	 * @return string
	 */
	public function fetch($sName = null, $bMainCall = true) 
	{
		if ($this->_bIsMobile) {

			if ($sName) {

				$sMobileTpl = self::$_sBasePath.str_replace('.tpl', 'Mobile.tpl', $sName);
				if (file_exists($sMobileTpl)) { $sName = str_replace('.tpl', 'Mobile.tpl', $sName); }
			}

			if (isset($this->_aVar['model'])) {

				$sMobileTpl = self::$_sBasePath.str_replace('.tpl', 'Mobile.tpl', $this->_aVar['model']);
				if (file_exists($sMobileTpl)) { $this->_aVar['model'] = str_replace('.tpl', 'Mobile.tpl', $this->_aVar['model']); }
			}
		}

		if ($sName !== null) { $this->_sTemplateName = $sName; }

		ob_start();

        $iFileModificationTime = filemtime(self::$_sBasePath.$this->_sTemplateName);

		if (file_exists(self::$_sCachePath.$this->_getEncodeTemplateName($this->_sTemplateName).'.cac.php')) {

			$iCacheModificationTime = filemtime(self::$_sCachePath.$this->_getEncodeTemplateName($this->_sTemplateName).'.cac.php');
		}
		else {

			$iCacheModificationTime = 0;
		}

		if ($iCacheModificationTime < $iFileModificationTime) {

			$sTemplate = file_get_contents(self::$_sBasePath.$this->_sTemplateName);
			$this->_transform($sTemplate, $this->_sTemplateName, $bMainCall, true);
		}
		else {

			$sTemplate = file_get_contents(self::$_sBasePath.$this->_sTemplateName);
			$this->_transform($sTemplate, $this->_sTemplateName, $bMainCall, false);
		}

		return ob_get_clean();
	}

	/**
	 * get the basepath
	 *
	 * @access public
	 * @return string
	 */
	public static function getBasePath() 
	{
		return self::$_sBasePath;
	}

	/**
	 * get the basepath
	 *
	 * @access public
	 * @return string
	 */
	public static function getCachePath() 
	{
		return self::$_sCachePath;
	}

	/**
	 * get the basepath
	 *
	 * @access public
	 * @param  int $iRenderLevel
	 * @return \Apollina\Template
	 */
	public function setRenderLevel($iRenderLevel) 
	{
	    self::$_iRenderLevel = $iRenderLevel;
		return $this;
	}

	/**
	 * get the basepath
	 *
	 * @access public
	 * @param  array $aDisableRenderLevel
	 * @return \Apollina\Template
	 */
	public function disableLevel($aDisableRenderLevel) 
	{
	    foreach ($aDisableRenderLevel as $iKey => $bRenderLevel) {

	        self::$_aDisableRenderLevel[$iKey] = $bRenderLevel;
	    }
	    
		return $this;
	}

	/**
	 * assign a variable for the template
	 *
	 * @access private
	 * @param  string $sContent content
	 * @param  string $sTemplateName tempalte name
	 * @param  boolean $bFirst if you call this for the first time
	 * @return bool
	 */
	private function _transform($sContent, $sTemplateName, $bFirst = false, $bDoCompilation = true) 
	{
	    if ($this->_bIsLayout === true && self::$_aDisableRenderLevel[1] === true 
	       && self::$_aDisableRenderLevel[2] === true) { 

	        $sContent = '';
	    }
	    else if ($this->_bIsLayout === true && self::$_aDisableRenderLevel[1] === true 
	       && self::$_aDisableRenderLevel[2] === false) { 

	        $sContent = preg_replace('/^(.*)\{include file=\$model\}(.*)$/msi', '$1$2', $sContent);
	    }
	    else if ($this->_bIsLayout === true && self::$_iRenderLevel < 2) { 

	        $sContent = preg_replace('/^.*(\{include file=\$model\}).*$/msi', '$1', $sContent);
	    }
	    else if (self::$_iRenderLevel < 1 || self::$_aDisableRenderLevel[1] === true) { 

	        $sContent = '';
	    }
	    
		//*****************************************************************************************************************************
		// NEW version
		// @deprecated
		//
		// {$foo[section_name]}? http://www.smarty.net/docs/en/language.syntax.variables.tpl
		//*****************************************************************************************************************************

		$sTmpDirectory = self::$_sCachePath;
		$sTmpDirectory = str_replace('\\', '\\\\\\', $sTmpDirectory);

		$sViewDirectory = self::$_sBasePath;

		$_aProtectedVar = $this->_aVar;
		$_aProtectedVar['app']['config'] = array();
		$_aProtectedVar['app']['server'] = $_SERVER;
		$_aProtectedVar['app']['get'] = $_GET;
		$_aProtectedVar['app']['post'] = $_POST;
		$_aProtectedVar['app']['cookies'] = $_COOKIE;
		$_aProtectedVar['app']['env'] = $_ENV;
		
		if (isset($_SESSION)) { $_aProtectedVar['app']['session'] = $_SESSION; }
		else { $_aProtectedVar['app']['session'] = array(); }
		
		$_aProtectedVar['app']['request'] = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV);
		$_aProtectedVar['app']['now'] = time();
		$_aProtectedVar['app']['const'] = get_defined_constants();
		$_aProtectedVar['app']['capture'] = array();					// link to {capture} -> to do it
		$_aProtectedVar['app']['section'] = array();					// link to {section} -> to do it
		$_aProtectedVar['app']['template'] = $this->_sTemplateName;
		$_aProtectedVar['app']['template_object'] = $this;
		$_aProtectedVar['app']['current_dir'] = $sViewDirectory;
		$_aProtectedVar['app']['version'] = self::VERSION;
		$_aProtectedVar['app']['block'] = array();						// link to {block} -> to do it
		$_aProtectedVar['app']['block']['child'] = null;
		$_aProtectedVar['app']['block']['parent'] = null;
		$_aProtectedVar['app']['ldelim'] = $this->_sLeftDelimiter;
		$_aProtectedVar['app']['rdelim'] = $this->_sRightDelimiter;

		//*****************************************************************************************************************************
		// tags: {counter}, {$SCRIPT_NAME}
		//*****************************************************************************************************************************

		$sContent = str_replace('{counter}', '$_aProtectedVar[\'i\']', $sContent);
		$sContent = str_replace('{$SCRIPT_NAME}', '$_aProtectedVar[\'app\'][\'SERVER\'][\'SCRIPT_NAME\']', $sContent);

		//*****************************************************************************************************************************
		// comments: {* this is a comment *}
		//*****************************************************************************************************************************

		$sContent = preg_replace('|\{\*|', '<?php /*', $sContent);
		$sContent = preg_replace('|\*\}|', '*/ ?>', $sContent);

		//*****************************************************************************************************************************
		// escape: {literal}function bazzy {alert('foobar!');}{/literal}
		//*****************************************************************************************************************************

		$sContent = preg_replace('|'.preg_quote($this->getLeftDelimiter()).'|', "\n".'<?php echo <<<EOF'."\n", $sContent);
		$sContent = preg_replace('|'.preg_quote($this->getRightDelimiter()).'|', "\n".'EOF;'."\n".'?>'."\n", $sContent);

		while (preg_match('|(<<<EOF(?:(?<!EOF;).)+?)\$(.+?EOF;)|msi', $sContent)) {

			$sContent = preg_replace('|(<<<EOF(?:(?<!EOF;).)+?)\$(.+?EOF;)|msi', '$1#DOLLAR#$2', $sContent);
		}


		//*****************************************************************************************************************************
		// variables: {$foo}, {$foo[4]}, {$foo.bar}, {$foo.$bar}, {$foo->bar}, {$foo->bar()}, {$foo.bar.baz}, {$foo.$bar.$baz},
		//				{$foo[4].baz}, {$foo[4].$baz}, {$foo.bar.baz[4]}, {$foo->bar($baz,2,$bar)}, {$app.config.foo},
		//				{$app.server.SERVER_NAME}, {$x+$y}, {$foo[$x+3]}, {$foo={counter}+3}, {$foo="this is message {counter}"},
		//				{$foo=$bar+2}, {$foo = strlen($bar)}, {$foo = myfunct( ($x+$y)*3 )}, {$foo.bar=1}, {$foo.bar.baz=1},
		//				{$foo[]=1}, {$foo.a.b.c}, {$foo.a.$b.c}, {$foo.a.{$b+4}.c}, {$foo.a.{$b.c}}, {$foo['bar']}, {$foo['bar'][1]},
		//				{$foo[$x+$x]}, {$foo[$bar[1]]}, $foo_{$bar}, $foo_{$x+$y}, $foo_{$bar}_buh_{$blar}, {$foo_{$x}}, {time()}
		//				{$foo+1}, {$foo*$bar}, {$app.get.page}, {$app.post.page}, {$app.cookies.page}, , {$app.anv.path},
		//				{$app.session.page}, {$app.request.page}, {$app.now}, {$app.const.page}, {$smarty.capture}, {$smarty.section},
		//				{$smarty.template}, {$smarty.current_dir}, {$smarty.version}, {$smarty.template_object}, {$smarty.block.child},
		//				{$smarty.block.parent}, {$app.ldelim}, {$app.rdelim}
		// particulier ;
		// version 1 forbiden : {$app['security']}, {$app['user']}, {$app['environment']}, {$app['debug']}
		//*****************************************************************************************************************************

		while (preg_match('|\{(.*?)\$([^_\(][a-z0-9_\[\]\->\(\)\+/*\']+)\.([a-z0-9_]+)(.*?)\}|msi', $sContent, $ret)) {

			$sContent = preg_replace('|\{(.*?)\$([^_\(][a-z0-9_\[\]\->\(\)\+/*\']+)\.([a-z0-9_]+)(.*?)\}|msi',
							'{'.'$1'.'$'.'$2[\'$3\']'.'$4'.'}', $sContent);
		}



		// {$foo.$bar.baz}

		$sContent = preg_replace('|\{(.*?)\$([^_\(][a-z0-9_]*)([a-z0-9_\[\].\->\(\)\+/*\']*)\.\$([^_][a-z0-9_]*)([a-z0-9_\[\]\->\(\)\+/*\']*)(.*?)\}|msi',
			'{'.'$1'.'$_aProtectedVar[\'$2\']$3[$_aProtectedVar[\'$4\']$5]'.'$6'.'}', $sContent);

		// {$foo.a.{$b.c}}

		$sContent = preg_replace('|\{(.*?)\$([^_\(][a-z0-9_]*)([a-z0-9_\[\].\->\(\)\+/*\']*)\.\{\$([^_][a-z0-9_]*)([a-z0-9_\[\]\->.\(\)\+/*\']*)\}(.*?)\}|msi',
						'{'.'$1'.'$_aProtectedVar[\'$2\']$3[$_aProtectedVar[\'$4\']$5]'.'$6'.'}', $sContent);

		// $foo_{$bar}, $foo_{$x+$y}, $foo_{$bar}_buh_{$blar}, {$foo_{$x}}

		$sContent = preg_replace('|\{(.*?)\$([^_\(][a-z0-9_]*?)_\{([a-z0-9_\+/*\->\$\(\)\[\]]*)([a-z0-9_\[\]\->\(\)\+/*\']*)\}(.*?)\}|msi',
						'{'.'$1'.'$_aProtectedVar[\'$2\'.($3)]'.'$5'.'}', $sContent);

		while (preg_match('|\{(.*?)\$([^_\(][a-z0-9_]*)([a-z0-9_\[\].\->\(\)\+/*\']*)(.*?)\}|msi', $sContent)) {

			$sContent = preg_replace('|\{(.*?)\$([^_\(][a-z0-9_]*)([a-z0-9_\[\].\->\(\)\+/*\']*)(.*?)\}|msi',
							'{'.'$1'.'$_aProtectedVar[\'$2\']$3'.'$4'.'}', $sContent);
		}

		//*****************************************************************************************************************************
		// var modifiers : {$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}
		//*****************************************************************************************************************************

		preg_match_all('#\{(\$_aProtectedVar[a-z0-9_\[\].\->\(\)\+/*\']*)\|([^:\}]+)([^\}]*)\}#msi', $sContent, $aMatchs, PREG_SET_ORDER);

		foreach ($aMatchs as $aOne) {

			$sName = ucfirst($aOne[2]);

			$sName = preg_replace('|_([a-z])|e', 'strtoupper("$1")', $sName);
			// replace the name of modifier which are a key name of php
			$sName = str_replace(array('Default'), array('StringDefault'), $sName);

			if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.'Modifiers'.DIRECTORY_SEPARATOR.$sName.'.php')) {

				$sClassName = '\Apollina\Template\Modifiers\\'.$sName;
				$oFunction = new $sClassName;
				$aAttributes = explode(' ', $aOne[3]);
				preg_match_all('#:([^:]+)#msi', $aOne[3], $aMatchs2, PREG_SET_ORDER);
				$aParams = [];
				$aParams[] = $aOne[1];
				$iIndex = 1;

				foreach ($aMatchs2 as $sOne2) {

					if (!isset($aParams[$iIndex])) { $aParams[$iIndex] = $sOne2[1]; }
					else { $aParams[$iIndex] .= $sOne2[1]; }

					if (substr($aParams[$iIndex], -1) == "'" && substr($aParams[$iIndex], 0, 1) == "'") { $iIndex++; }
					else if (substr($aParams[$iIndex], -1) == '"' && substr($aParams[$iIndex], 0, 1) == '"') { $iIndex++; }
					else if (substr($aParams[$iIndex], 0, 1) != '"' && substr($aParams[$iIndex], 0, 1) != "'") { $iIndex++; }
					else { $aParams[$iIndex] .= ":"; }
				}

				$oFunction->run($aParams);
				$sContent = str_replace($aOne[0], call_user_func_array(array($oFunction, 'replaceBy') , $aParams), $sContent);
			}
		}

		//*****************************************************************************************************************************
		// transformation all : {$ssdsd} in <php echo ; >
		//*****************************************************************************************************************************

		$sContent = preg_replace('|\{(\$[a-z0-9_\[\].\->\(\)\$\+/*\'=+]+)\}|msi', '<?php echo $1; ?>', $sContent);
		$sContent = preg_replace('|\{([a-z0-9_\(\),.]+\(\$[a-z0-9_\[\].\->\(\)\$\+/*\'"]+[ a-z0-9_\(\),".]+)\}|msi', '<?php echo $1; ?>', $sContent);
		$sContent = preg_replace('|\{([a-z0-9_\(\),.]+\([^\}]+\))\}|msi', '<?php echo $1; ?>', $sContent);

		$sContent = preg_replace('|echo echo|', 'echo', $sContent);

		//*****************************************************************************************************************************
		// escape: {ldelim}function{/rdelim}
		//*****************************************************************************************************************************

		$sContent = preg_replace('|<?php echo ldelim; ?>|', '{', $sContent);
		$sContent = preg_replace('|<?php echo rdelim; ?>|', '}', $sContent);

		//*****************************************************************************************************************************
		// variables: {#foo#}
		//*****************************************************************************************************************************

		$sContent = preg_replace('|\{#([a-z0-9_]+)#\}|msi', '<?php echo $_aProtectedVar[\'app\'][\'config\'][\'$1\']; ?>', $sContent);

		//*****************************************************************************************************************************
		// variables: {"foo"}
		//*****************************************************************************************************************************

		$sContent = preg_replace('|\{"([^"]+)"\}|msi', '<?php echo "$1"; ?>', $sContent);

		//*****************************************************************************************************************************
		// {$nale='dsds'}
		//*****************************************************************************************************************************

		$sContent = preg_replace('|\{(\$_aProtectedVar[^= }]+=[\'"][^\'"}]+[\'"])\}|msi', '<?php $1'.'; ?>', $sContent);

		//*****************************************************************************************************************************
		// variables: {funcname attr1="val1" attr2="val2"}
		//				{assign var=foo value={counter}}
		//				{html_select_date display_days=true}
		//				{mailto address="smarty@example.com"}
		//				{html_options options=$companies selected=$company_id}
		//				{include file="subdir/$tpl_name.tpl"} => exception : class ToInclude
		//				{cycle values="one,two,`$smarty.config.myval`"}
		//				{config_load file='foo.conf'}
		//				{url alias='home' ...}
		//*****************************************************************************************************************************

		preg_match_all('|\{([a-z0-9_]+) +([a-z]+=[^\}]+)\}|msi', $sContent, $aMatchs, PREG_SET_ORDER);

		foreach ($aMatchs as $aOne) {

			$sName = ucfirst($aOne[1]);

			$sName = preg_replace_callback('|_([a-z])|', function ($aMatches) {
				return strtoupper($aMatches[1]);
			}, $sName);

			if ($sName == 'Include') { $sName = 'ToInclude'; }
			if ($sName == 'Foreach') { $sName = 'ToForeach'; }

			if (file_exists(__DIR__.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.'Functions'.DIRECTORY_SEPARATOR.$sName.'.php')) {

				$sClassName = 'Apollina\Template\Functions\\'.$sName;
				$oFunction = new $sClassName;
				$aAttributes = explode(' ', $aOne[2]);

				$aParams = [];

				foreach ($aAttributes as $sOne2) {

					$aSplitParams = explode('=', $sOne2);
					$aParams[$aSplitParams[0]] = $aSplitParams[1];
				}

				if ($sName == 'ToInclude') {

					if (preg_match('/_aProtectedVar/', $aParams['file'])) {

						$sModelToCall = str_replace(array("\$_aProtectedVar['", "']", "'", '"'), array('', '' , '', ''), $aParams['file']);
						$aParams['real_name'] = $_aProtectedVar[$sModelToCall];
					}
					else {

						$aParams['real_name'] = str_replace(array("'", '"'), array('', ''), $aParams['file']);
					}
				}

				$sContent = str_replace($aOne[0], $oFunction->replaceBy($aParams), $sContent);
			}
		}

		//*****************************************************************************************************************************
		// variables: {include model}
		//*****************************************************************************************************************************

		if (preg_match('|\{include model\}|', $sContent)) {

			if ($this->_bIsMobile && file_exists(self::$_sBasePath.str_replace('.tpl', 'Mobile.tpl', $_aProtectedVar['model']))) {

				$this->_transform(file_get_contents(self::$_sBasePath.str_replace('.tpl', 'Mobile.tpl', $_aProtectedVar['model'])), str_replace('.tpl', 'Mobile.tpl', $_aProtectedVar['model']));
			}
			else {

				//$sModelname = str_replace(array('src/'.PORTAIL.'/View/', 'src\\'.PORTAIL.'\View\\', '\\'), array('', '', ''), $_aProtectedVar['model']);
				$this->_transform(file_get_contents(self::$_sBasePath.$sModelname), $sModelname);
			}
		}

		//*****************************************************************************************************************************
		// variables: {if $foo > 3}{elseif $foo > 3}{else}{/if}
		//				{foreachelse} execute program if the array of foreach is empty
		//				{/foreach} to close foreach
		//*****************************************************************************************************************************

		$sContent = preg_replace('|\{if ([^\}]+)\}|', '<?php if ($1) { ?>', $sContent);
		$sContent = preg_replace('|\{elseif ([^\}]+)\}|', '<?php } else if ($1) { ?>', $sContent);
		$sContent = str_replace(array('{else}', '{foreachelse}'), '<?php } else { ?>', $sContent);
		$sContent = str_replace('{/foreach}', '<?php }} ?>', $sContent);
		$sContent = str_replace(array('{/if}', '{/section}'), '<?php } ?>', $sContent);

		//*****************************************************************************************************************************
		// finition
		//*****************************************************************************************************************************

		//$sContent = preg_replace('|\{|msi', '<?php ', $sContent);
		//$sContent = preg_replace('|\}|msi', ' ? >', $sContent);

		while (preg_match('|(<<<EOF(?:(?<!EOF;).)+?)#DOLLAR#(.+?EOF;)|msi', $sContent)) {

			$sContent = preg_replace('|(<<<EOF(?:(?<!EOF;).)+?)#DOLLAR#(.+?EOF;)|msi', '$1'.'\\\$'.'$2', $sContent);
		}

		$sContent .= "\n".'<?php /* '.print_r(str_replace('\\\\\\', '/', $sTmpDirectory).$this->_getEncodeTemplateName($sTemplateName).'.cac.php', true).' */ ?>';
		$sContent .= "\n".'<?php /* template : '.$sTemplateName.' */ ?>';
		$sContent .= "\n".'<?php /* '.print_r(file_put_contents(str_replace('\\\\\\', '/', $sTmpDirectory).$this->_getEncodeTemplateName($sTemplateName).'.cac.php', $sContent), true).' */ ?>';
		$sContent .= "\n".'<?php /* '.str_replace('\\\\\\', '/', $sTmpDirectory).' = '.$sTemplateName.' = '.md5($sTemplateName).' */ ?>';
	
		if ($bFirst === true) {

			include(str_replace('\\\\\\', '/', $sTmpDirectory).$this->_getEncodeTemplateName($sTemplateName).'.cac.php');
		}
	}

	/**
	 * get the encode name od the template
	 *
	 * @access private
	 * @param  array $aMatch match of preg
	 * @return string
	 */
	private function _includeTransform($aMatch) 
	{
		eval('$oTemplate = new \Apollina\Template($this->_aVar[\''.$aMatch[1].'\']'.$aMatch[2].'); $oTemplate->fetch(null, false);');
		return '<?php include "'.$this->sTmpDirectory.'".md5($aProtectedVar[\''.$aMatch[1].'\']'.$aMatch[2].').".cac.php"; ?>';
	}

	/**
	 * get the encode name od the template
	 *
	 * @access private
	 * @param  array $aMatch match of preg
	 * @return string
	 */
    private function _includeTransform2($aMatch) 
    {
		$sViewDirectory = self::$_sBasePath;
		eval('$oTemplate = new \Apollina\Template("'.self::$_sBasePath.$aMatch[1].'"); $oTemplate->fetch(null, false);');
		return '<?php include "'.$this->sTmpDirectory.'".md5("'.$aMatch[1].'").".cac.php"; ?>';
	}

	/**
	 * get the encode name od the template
	 *
	 * @access private
	 * @param  string $sName name of the template
	 * @return string
	 */
	private function _getEncodeTemplateName($sName) 
	{
		$sName = str_replace('\\', '/', $sName);
		//$sName = str_replace('/src', 'src', $sName);
		return md5($sName);
	}
}
