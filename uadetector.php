<?php
/**
 * ---------------------------------------------------------------------------------------------------------
 * User Agent detector plugin
 *
 * Version 1.0.15
 *
 * Copyright (C) 2016 Rene Kreijveld. All rights reserved.
 *
 * User Agent detector is free software and is distributed under the GNU General Public License,
 * and as distributed it may include or be derivative of works licensed under the GNU
 * General Public License or other free or open source software licenses.
 * ---------------------------------------------------------------------------------------------------------
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * UADetector Plugin
 */
class plgSystemUadetector extends JPlugin
{
	public function onAfterInitialise()
	{
		// If class Mobile_Detect does not exist load include file.
		if (!class_exists('Mobile_Detect'))
		{
			include_once( dirname(__FILE__) . '/lib/Mobile_Detect.php' );
		}

		if ( class_exists( 'Mobile_Detect' ) )
		{
			$detect = new Mobile_Detect();
			$layout = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
			if ( $detect->is('Bot') || $detect->is('MobileBot') ) $layout = 'bot';

			// store user agent layout in session variable.
			$session = JFactory::getSession();
			$session->set('ualayout', $layout);
		}
		else
		{
			// class not present, default to desktop
			$session = JFactory::getSession();
			$session->set('ualayout', 'desktop');
		}
	}
}