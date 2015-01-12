<?php

/**
 * Manage Template
 *
 * @category  	Apollina
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus2/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
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
 * @version   	Release: 1.0.0
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
	 * @var    \Venus\lib\Template
	 */
	private $_oTemplateLink = null;

	/**
	 * constructor of class
	 *
	 * @access public
	 * @param  string $sName name of the template
	 * @return \Venus\lib\Template
	 */
	public function __construct($sName = null) 
	{
		$oMobileDetect = new \Mobile_Detect;

		if ($oMobileDetect->isMobile()) {

			if ($sName && is_string($sName) && strstr($sName, '.tpl')) {

				$sMobileTpl = str_replace('lib', '', __DIR__).str_replace('.tpl', 'Mobile.tpl', $sName);
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
	 * @return \Venus\lib\Template
	 */
	public function caching($iValue) 
	{
		$this->_iCaching = $iValue;
		return $this;
	}

	/**
	 * create link
	 *
	 * @access public
	 * @param  \Venus\lib\Template $oTemplate datas to add
	 * @return \Venus\lib\Template
	 */
	public function createData(\Venus\lib\Template $oTemplate = null) 
	{
		$oNewTemplate = new \Venus\lib\Template;

		if ($oTemplate !== null) {

			$oNewTemplate = $oTemplate->assignAll($this->_aVar);
			$this->_oTemplateLink = $oTemplate;
		}

		return $oNewTemplate;
	}

	/**
	 * caching templates
	 *
	 * @access public
	 * @param  int $iValue caching kind
	 * @return \Venus\lib\Template
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
	 * @return \Venus\lib\Template
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
	 * @return \Venus\lib\Template
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
	 * @return \Venus\lib\Template
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
	 * @return \Venus\lib\Template
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
	 * @param  \Venus\lib\Template $oTemplate datas to add
	 * @return bool
	 */
	public function display($sName = null, \Venus\lib\Template $oTemplate = null) 
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
		$oMobileDetect = new \Mobile_Detect;

		if ($oMobileDetect->isMobile()) {

			if ($sName) {

				$sMobileTpl = str_replace('lib', '', __DIR__).str_replace('.tpl', 'Mobile.tpl', $sName);
				if (file_exists($sMobileTpl)) { $sName = str_replace('.tpl', 'Mobile.tpl', $sName); }
			}

			if (isset($this->_aVar['model'])) {

				$sMobileTpl = str_replace('lib', '', __DIR__).str_replace('.tpl', 'Mobile.tpl', $this->_aVar['model']);
				if (file_exists($sMobileTpl)) { $this->_aVar['model'] = str_replace('.tpl', 'Mobile.tpl', $this->_aVar['model']); }
			}
		}

		if ($sName !== null) { $this->_sTemplateName = $sName; }

		ob_start();

		if (!strstr($this->_sTemplateName, 'View')) {

			$iFileModificationTime = filemtime(str_replace('lib', '', __DIR__).'src'.DIRECTORY_SEPARATOR.PORTAIL.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR.$this->_sTemplateName);
		}
		else {

			$iFileModificationTime = filemtime(str_replace('lib', '', __DIR__).$this->_sTemplateName);
		}

		$sTmpDirectory = str_replace('private'.DIRECTORY_SEPARATOR.'lib', CACHE_DIR, __DIR__).DIRECTORY_SEPARATOR;

		if (file_exists($sTmpDirectory.$this->_getEncodeTemplateName($this->_sTemplateName).'.cac.php')) {

			$iCacheModificationTime = filemtime($sTmpDirectory.$this->_getEncodeTemplateName($this->_sTemplateName).'.cac.php');
		}
		else {

			$iCacheModificationTime = 0;
		}

		if ($iCacheModificationTime < $iFileModificationTime) {

			$sTemplate = file_get_contents(str_replace('lib', '', __DIR__).$this->_sTemplateName);
			$this->_transform($sTemplate, $this->_sTemplateName, $bMainCall, true);
		}
		else {

			$sTemplate = file_get_contents(str_replace('lib', '', __DIR__).$this->_sTemplateName);
			$this->_transform($sTemplate, $this->_sTemplateName, $bMainCall, false);
		}

		return ob_get_clean();
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
		//*****************************************************************************************************************************
		// NEW version
		// @deprecated
		//
		// {$foo[section_name]}? http://www.smarty.net/docs/en/language.syntax.variables.tpl
		//*****************************************************************************************************************************

		$sTmpDirectory = str_replace('private'.DIRECTORY_SEPARATOR.'lib', CACHE_DIR, __DIR__).DIRECTORY_SEPARATOR;
		$sTmpDirectory = str_replace('\\', '\\\\\\', $sTmpDirectory);

		$sViewDirectory = str_replace('lib', 'src'.DIRECTORY_SEPARATOR.PORTAIL.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR, __DIR__).DIRECTORY_SEPARATOR;
		$sViewDirectory = str_replace('\\', '\\\\\\', $sViewDirectory);

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

				$sClassName = '\Venus\lib\Template\Modifiers\\'.$sName;
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

				$sClassName = 'Venus\lib\Template\Functions\\'.$sName;
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

				$oFunction->run($aParams);
				$sContent = str_replace($aOne[0], $oFunction->replaceBy($aParams), $sContent);
			}
		}

		//*****************************************************************************************************************************
		// variables: {include model}
		//*****************************************************************************************************************************

		if (preg_match('|\{include model\}|', $sContent)) {

			$sContent = preg_replace('|\{include model\}|', '<?php $_aProtectedVar[\'model\'] = preg_replace("#^.+[^a-zA-Z0-9_-]([a-zA-Z0-9_-]+\.tpl)$#msi", "\$1", $_aProtectedVar[\'model\']); $oMobileDetect = new \Mobile_Detect; if ($oMobileDetect->isMobile() && file_exists("'.$sTmpDirectory.'".md5(str_replace(".tpl", "Mobile.tpl", str_replace("\\\\\\\\", "/", $_aProtectedVar[\'model\']))).".cac.php")) { include "'.$sTmpDirectory.'".md5(str_replace(".tpl", "Mobile.tpl", str_replace("\\\\\\\\", "/", $_aProtectedVar[\'model\']))).".cac.php"; } else { include "'.$sTmpDirectory.'".md5(str_replace("\\\\\\\\", "/", $_aProtectedVar[\'model\'])).".cac.php"; } ?>', $sContent);

			$oMobileDetect = new \Mobile_Detect;

			if ($oMobileDetect->isMobile() && file_exists(str_replace('lib', 'src/'.PORTAIL.'/View/', __DIR__).str_replace('.tpl', 'Mobile.tpl', $_aProtectedVar['model']))) {

				$this->_transform(file_get_contents(str_replace('lib', 'src/'.PORTAIL.'/View/', __DIR__).str_replace('.tpl', 'Mobile.tpl', $_aProtectedVar['model'])), str_replace('.tpl', 'Mobile.tpl', $_aProtectedVar['model']));
			}
			else {

				$sModelname = str_replace(array('src/'.PORTAIL.'/View/', 'src\\'.PORTAIL.'\View\\', '\\'), array('', '', ''), $_aProtectedVar['model']);
				$this->_transform(file_get_contents(str_replace('lib', 'src/'.PORTAIL.'/View/', __DIR__).$sModelname), $sModelname);
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
		eval('$oTemplate = new \Venus\lib\Template($this->_aVar[\''.$aMatch[1].'\']'.$aMatch[2].'); $oTemplate->fetch(null, false);');
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
		$sViewDirectory = str_replace('lib', 'src'.DIRECTORY_SEPARATOR.PORTAIL.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR, __DIR__);
		$sViewDirectory = str_replace('\\', '\\\\\\', $sViewDirectory);
		//echo '$oTemplate = new \Venus\lib\Template("src".DIRECTORY_SEPARATOR.PORTAIL.DIRECTORY_SEPARATOR."View".DIRECTORY_SEPARATOR."'.$aMatch[1].'"); $oTemplate->fetch(null, false);';
		eval('$oTemplate = new \Venus\lib\Template("src".DIRECTORY_SEPARATOR.PORTAIL.DIRECTORY_SEPARATOR."View".DIRECTORY_SEPARATOR."'.$aMatch[1].'"); $oTemplate->fetch(null, false);');
		//eval('$oTemplate = new \Venus\lib\Template("'.$aMatch[1].'"); $oTemplate->fetch(null, false);');
		return '<?php include "'.$this->sTmpDirectory.'".md5("src".DIRECTORY_SEPARATOR.PORTAIL.DIRECTORY_SEPARATOR."View".DIRECTORY_SEPARATOR."'.$aMatch[1].'").".cac.php"; ?>';
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
