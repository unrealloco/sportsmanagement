<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage predictiongames
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;

/**
 * sportsmanagementViewPredictionGames
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewPredictionGames extends sportsmanagementView
{
	
	/**
	 * sportsmanagementViewPredictionGames::init()
	 * 
	 * @return void
	 */
	public function init ()
	{
		$starttime = microtime();
		$modalheight = ComponentHelper::getParams($this->option)->get('modal_popup_height', 600);
		$modalwidth = ComponentHelper::getParams($this->option)->get('modal_popup_width', 900);
		$this->modalheight	= $modalheight;
		$this->modalwidth	= $modalwidth;

		$lists = array();

		$this->prediction_id = $this->state->get('filter.prediction_id');
		if ( $this->prediction_id != 0 )
			{
			}
		else
			{
				$this->prediction_id = $this->jinput->request->get('prediction_id', 0);
			} 
       
        $table = JTable::getInstance('predictiongame', 'sportsmanagementTable');
		$this->table	= $table;
        
		if ( !$this->items )
			{
				$this->app->enqueueMessage(Text::_('COM_SPORTSMANAGEMENT_ADMIN_PGAMES_NO_GAMES'),'Error');
			}
        


		//build the html select list for prediction games
		$predictions[] = HTMLHelper::_( 'select.option', '0', Text::_( 'COM_SPORTSMANAGEMENT_GLOBAL_SELECT_PRED_GAME' ), 'value', 'text' );
		if ( $res = $this->model->getPredictionGames() )
        { 
			$predictions = array_merge( $predictions, $res );
			$this->prediction_ids	= $res;
		}
		
		$lists['predictions'] = HTMLHelper::_(	'select.genericlist', 
											$predictions, 
											'filter_prediction_id', 
											'class="inputbox" onChange="this.form.submit();" ', 
											'value', 
											'text', 
											$this->state->get('filter.prediction_id')
										);
		unset( $res );

		$this->lists	= $lists;
		$this->dPredictionID	= $this->prediction_id;
		
		if ( $this->prediction_id > 0 )
		{
			$this->predictionProjects	= $this->getModel()->getChilds( $this->prediction_id );
		}
    
	}
    
    /**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{ 
        // Set toolbar items for the page
		$this->title = Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_PGAMES_TITLE' );
		$this->icon = 'pred-cpanel';
		JToolbarHelper::publish('predictiongames.publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('predictiongames.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolbarHelper::divider();
		JToolbarHelper::editList('predictiongame.edit');
		JToolbarHelper::addNew('predictiongame.add');
		JToolbarHelper::custom('predictiongame.import','upload','upload',Text::_('JTOOLBAR_UPLOAD'),false);
		JToolbarHelper::archiveList('predictiongame.export',Text::_('JTOOLBAR_EXPORT'));
		parent::addToolbar();  
        
	}
    
    

}
?>
