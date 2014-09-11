<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie können es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
* veröffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es nützlich sein wird, aber
* OHNE JEDE GEWÄHELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License für weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

//jimport( 'joomla.application.component.view' );
//jimport('joomla.form.form');


/**
 * sportsmanagementViewPredictionTemplate
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2013
 * @access public
 */
class sportsmanagementViewPredictionTemplate extends sportsmanagementView
{
	
	/**
	 * sportsmanagementViewPredictionTemplate::init()
	 * 
	 * @return
	 */
	public function init ()
	{
		$mainframe	= JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $model = $this->getModel();
        
        $this->prediction_id		= $mainframe->getUserState( "$option.predid", '0' );
        $predictionGame = $model->getPredictionGame( $this->prediction_id );

        
        	// get the Data
		//$form = $this->get('Form');
		$item = $this->get('Item');
		$script = $this->get('Script');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
        $templatepath=JPATH_COMPONENT_SITE.DS.'settings';
    $xmlfile=$templatepath.DS.'default'.DS.$item->template.'.xml';
    
    //$jRegistry = new JRegistry;
//		$jRegistry->loadString($item->params, 'ini');
        
        //$mainframe->enqueueMessage(JText::_('sportsmanagementViewPredictionTemplate params<br><pre>'.print_r($item->params ,true).'</pre>'),'Notice');
        
        //$jRegistry->loadJSON($item->params);
        //$item->params = $jRegistry->toArray($item->params);
        //$mainframe->enqueueMessage(JText::_('sportsmanagementViewPredictionTemplate params<br><pre>'.print_r($item->params ,true).'</pre>'),'Notice');
        
		$form = JForm::getInstance($item->template, $xmlfile,array('control'=> 'params'));
		//$form->bind($jRegistry);
        $form->bind($item->params);
		$this->form = $form;
		$this->item = $item;
		$this->script = $script;
        $this->assign('user',JFactory::getUser() );
        $this->assignRef( 'predictionGame',		$predictionGame );

	}

	

  /**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{
        
        JRequest::setVar('hidemainmenu', true);
        $isNew = $this->item->id ? $this->title = JText::_('COM_SPORTSMANAGEMENT_PREDICTIONTEMPLATE_EDIT') : $this->title = JText::_('COM_SPORTSMANAGEMENT_PREDICTIONTEMPLATE_NEW');
        $this->icon = 'predtemplate';

        parent::addToolbar();

	}		
	
}
?>
