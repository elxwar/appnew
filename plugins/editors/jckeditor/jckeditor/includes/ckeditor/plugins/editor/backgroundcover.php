<?php


defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.event.plugin');
jckimport('ckeditor.htmlwriter.javascript');


class plgEditorBackGroundCover extends JPlugin 
{
  	function plgEditorBackGroundCover(&$subject, $config) 
	{
		parent::__construct($subject, $config);
	}

	function beforeLoad(&$params)
	{
		
		//lets create JS object	
		$javascript = new JCKJavascript();
		$javascript->addScriptDeclaration(
			"editor.on( 'configLoaded', function()
			{
				editor.config.dialog_backgroundCoverColor = '#000000';
				editor.config.dialog_backgroundCoverOpacity = 0.7;
			});"	
		);
		return $javascript->toRaw();
	}
}