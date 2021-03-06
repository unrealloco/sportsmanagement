<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      helper.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage mod_sportsmanagement_teamplayers
 */

/**
 * no direct access
 */
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

/**
 * modSportsmanagementTeamPlayersHelper
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class modSportsmanagementTeamPlayersHelper
{

	/**
	 * Method to get the list
	 *
	 * @access public
	 * @return array
	 */
	public static function getData(&$params)
	{
	   $mainframe = Factory::getApplication();
       
		$p = (int) $params->get('p');
		$t = (int) $params->get('team');
        
		$db  = Factory::getDBO();
        $query = $db->getQuery(true);
        
        $query->select('tt.id AS id, t.name AS team_name, s.id as season_id');
        $query->from('#__sportsmanagement_project_team as tt ');
        $query->join('INNER',' #__sportsmanagement_project as p ON p.id = tt.project_id ');
        $query->join('INNER',' #__sportsmanagement_season as s ON s.id = p.season_id ');
        $query->join('INNER',' #__sportsmanagement_season_team_id as st ON st.id = tt.team_id ');
        $query->join('INNER',' #__sportsmanagement_team as t ON t.id = st.team_id ');
        
        $query->where('tt.project_id = '. $p);
        $query->where('st.team_id = '. $t);
		
        $query->setLimit('1');
        
        $db->setQuery( $query );
        if ( $params['debug_modus'] )
	{		
        $mainframe->enqueueMessage(Text::_(__FILE__.' '.__LINE__.' <br><pre>'.print_r($query->dump(),true).'</pre>'),'');
	}
		$result = $db->loadRow();
		$projectteamid = $result[0];
		$team_name     = $result[1];
		$season_id     = $result[2];

		JRequest::setVar( 'p', $p );
		JRequest::setVar( 'tid', $t);
		JRequest::setVar( 'ttid', $projectteamid);

		if (!class_exists('sportsmanagementModelRoster')) 
        {
			require_once(JPATH_SITE.DS.JSM_PATH.DS.'models'.DS.'roster.php');
		}
		$model = BaseDatabaseModel::getInstance('Roster', 'sportsmanagementModel');
		sportsmanagementModelProject::$projectid = $p;
		$project = sportsmanagementModelProject::getProject();
		$project->team_name = $team_name;
        $model::$seasonid = $season_id;
        
        $db->disconnect(); // See: http://api.joomla.org/cms-3/classes/JDatabaseDriver.html#method_disconnect
        
		return array('project' => $project, 'roster' => $model->getTeamPlayers());
	}

	/**
	 * modSportsmanagementTeamPlayersHelper::getPlayerLink()
	 * 
	 * @param mixed $item
	 * @param mixed $params
	 * @param mixed $project
	 * @return void
	 */
	public static function getPlayerLink($item, $params, $project,$module)
	{
		$flag = "";
		if ($params->get('show_player_flag')) {
			$flag = JSMCountries::getCountryFlag($item->country) . "&nbsp;";
		}
		$text = "<i>".sportsmanagementHelper::formatName(null, $item->firstname, 
													$item->nickname, 
													$item->lastname, 
													$params->get("name_format")) . "</i>";
		if ($params->get('show_player_link'))
		{
		  $routeparameter = array();
$routeparameter['cfg_which_database'] = $params->get('cfg_which_database');
$routeparameter['s'] = $params->get('s');
$routeparameter['p'] = $item->project_slug;
$routeparameter['tid'] = $item->team_slug;
$routeparameter['pid'] = $item->person_slug;
$link = sportsmanagementHelperRoute::getSportsmanagementRoute('player',$routeparameter);

			echo $flag . HTMLHelper::link($link, $text);
		}
		else
		{
			echo '<i>' . Text::sprintf( '%1$s', $flag . $text) . '</i>';
		}

	}
}
