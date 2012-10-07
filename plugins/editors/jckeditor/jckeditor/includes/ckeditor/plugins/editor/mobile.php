<?php


defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.event.plugin');
jckimport('ckeditor.htmlwriter.javascript');


class plgEditorMobile extends JPlugin 
{
  	function plgEditorMobile(&$subject, $config) 
	{
		parent::__construct($subject, $config);
	}

	function beforeLoad(&$params)
	{
		//lets create JS object	
		$javascript = new JCKJavascript();
		
		$script = "editor.on( 'configLoaded', function()
		{
			if(editor.config.extraPlugins)
				editor.config.extraPlugins += ',mobilefloatpanelfix,mobileviewport,mobilemodalfix';
			else
				editor.config.extraPlugins += ',mobilefloatpanelfix,mobileviewport,mobilemodalfix';
		});";
	
		if(defined('JCK_MOBILE'))
		{	
			$script .= chr(13)  . "editor.colorButton_enableMore = false;
			
			editor.on( 'configLoaded', function()
			{
			  editor.config.startupFocus = 1;
			  editor.config.resize_minWidth = 100;
			  if(editor.config.removePlugins)
					editor.config.removePlugins += ',jfilebrowser';
				else 	
					editor.config.removePlugins += 'jfilebrowser';
			});";
		}
		$javascript->addScriptDeclaration($script);
		return $javascript->toRaw();
	}
}