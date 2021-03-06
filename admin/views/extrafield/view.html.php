<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage extrafield
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory; 

/**
 * sportsmanagementViewextrafield
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewextrafield extends sportsmanagementView
{
	
	
	/**
	 * sportsmanagementViewextrafield::init()
	 * 
	 * @return
	 */
	public function init ()
	{
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
//		// Assign the Data
//		$this->form = $form;
//		$this->item = $item;
//		$this->script = $script;
		
//		$extended = sportsmanagementHelper::getExtended($item->extended, 'jlextcountry');
//		$this->assignRef( 'extended', $extended );
		$this->cfg_which_media_tool	= JComponentHelper::getParams($this->option)->get('cfg_which_media_tool', 0);
 

	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
        $app	= Factory::getApplication();
		$jinput	= $app->input;
		$jinput->set('hidemainmenu', true);
        
        $isNew = $this->item->id ? $this->title = Text::_('COM_SPORTSMANAGEMENT_EXTRAFIELD_EDIT') : $this->title = Text::_('COM_SPORTSMANAGEMENT_EXTRAFIELD_NEW');
        $this->icon = 'extrafield';
		
        parent::addToolbar();
	}
    

}
