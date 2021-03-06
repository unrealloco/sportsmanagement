<?php
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage smquotes
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;

/**
 * sportsmanagementViewsmquotes
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewsmquotes extends sportsmanagementView
{
	
	/**
	 * sportsmanagementViewsmquotes::init()
	 * 
	 * @return void
	 */
	public function init ()
	{
	
        $this->table = Table::getInstance('smquote', 'sportsmanagementTable');
        	
	}
	
	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{
        // Set toolbar items for the page
		$this->title = Text::_('COM_SPORTSMANAGEMENT_ADMIN_QUOTES_TITLE');
		JToolbarHelper::addNew('smquote.add');
		JToolbarHelper::editList('smquote.edit');
		JToolbarHelper::custom('smquote.import', 'upload', 'upload', Text::_('JTOOLBAR_UPLOAD'), false);
        
        JToolbarHelper::custom('smquotes.edittxt', 'featured.png', 'featured_f2.png', Text::_('JTOOLBAR_EDIT'), false);
        
		$bar = JToolBar::getInstance('toolbar');
        //$bar->appendButton('Link', 'info', 'Kategorie', 'index.php?option=com_categories&view=categories&extension=com_sportsmanagement');
		$bar->appendButton('Link', 'info', 'Kategorie', 'index.php?option=com_categories&extension=com_sportsmanagement');
        
		JToolbarHelper::archiveList('smquote.export', Text::_('JTOOLBAR_EXPORT'));
		
        
		parent::addToolbar();
	}
}
?>
