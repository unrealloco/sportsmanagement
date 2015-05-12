<?php 
/** SportsManagement ein Programm zur Verwaltung f?r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: ? 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
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
* SportsManagement ist Freie Software: Sie k?nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp?teren
* ver?ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n?tzlich sein wird, aber
* OHNE JEDE GEW?HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew?hrleistung der MARKTF?HIGKEIT oder EIGNUNG F?R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f?r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

require_once(JPATH_SITE.DS.JSM_PATH.DS.'assets'.DS.'classes'.DS.'open-flash-chart'.DS.'open-flash-chart.php' );

/**
 * sportsmanagementViewCurve
 * 
 * @package 
 * @author abcde
 * @copyright 2015
 * @version $Id$
 * @access public
 */
class sportsmanagementViewCurve extends JViewLegacy
{
	/**
	 * sportsmanagementViewCurve::display()
	 * 
	 * @param mixed $tpl
	 * @return void
	 */
	function display($tpl = null)
	{
		$option = JRequest::getCmd('option');
		
		// Get a reference of the page instance in joomla
		$document = JFactory::getDocument();
		$uri      = JFactory::getURI();
		$js = $this->baseurl . '/components/'.$option.'/assets/js/json2.js';
		$document->addScript($js);
		$js = $this->baseurl . '/components/'.$option.'/assets/js/swfobject.js';
		$document->addScript($js);

		$division = JRequest::getInt('division', 0);

		$model = $this->getModel();
		$rankingconfig = sportsmanagementModelProject::getTemplateConfig( "ranking",$model::$cfg_which_database );
		$flashconfig = sportsmanagementModelProject::getTemplateConfig( "flash",$model::$cfg_which_database );
		$config = sportsmanagementModelProject::getTemplateConfig($this->getName(),$model::$cfg_which_database);

		$this->assignRef('project', sportsmanagementModelProject::getProject($model::$cfg_which_database) );

		if ( isset( $this->project ) )
		{
			$this->assignRef('overallconfig',sportsmanagementModelProject::getOverallConfig($model::$cfg_which_database) );
			if ( !isset( $this->overallconfig['seperator'] ) )
			{
				$this->overallconfig['seperator'] = ":";
			}
			$this->assignRef('config',$config );
			$this->assignRef('model',$model);
			
			$this->assignRef('colors',sportsmanagementModelProject::getColors($rankingconfig['colors'],$model::$cfg_which_database) );
			$this->assignRef('division',$model->getDivision($division));
			$this->assignRef('team1',$model->getTeam1($division) );
			$this->assignRef('team2',$model->getTeam2($division) );
			
			$this->_setChartdata(array_merge($flashconfig, $rankingconfig));
		}
		//parent::display( $tpl );
	}

	/**
	 * assign the chartdata object for open flash chart library
	 * @param $config
	 * @return unknown_type
	 */
	function _setChartdata($config)
	{
		$model = $this->getModel();
		$rounds	= sportsmanagementModelProject::getRounds('ASC',$model::$cfg_which_database);
		$round_labels = array();
		foreach ($rounds as $r) {
			$round_labels[] = $r->name;
		}
		$division	= $this->get('division');
		$data = $model->getDataByDivision($division->id);
		//create a line
		$length = (count($rounds)-0.5);
		$linewidth = $config['color_legend_line_width'];
		$lines = array();
		
		//$title = $division->name;
		$chart = new open_flash_chart();
		//$chart->set_title( $title );
		$chart->set_bg_colour($config['bg_colour']);

		//colors defined for ranking table lines
		//todo: add support for more than 2 lines
		foreach( $this->colors as $color )
		{
			foreach ( $rounds AS $r )
			{
				for ( $n = $color['from']; $n <= $color['to']; $n++ )
				{
					$lines[$color['color']][$n][] = $n;
				}
			}
		}
		//set lines on the graph
		foreach( $lines AS $key => $value )
		{
			foreach( $value AS $line =>$key2 )
			{
				$chart->add_element( hline($key,$length,$line,$linewidth) );
			}
		}
		//load team1, first team in the dropdown
		$team = $this->team1; 
		
		$d = new $config['dotstyle_1']();
		$d->size((int) $config['line1_dot_strength']);
		$d->halo_size(1);
		$d->colour($config['line1']);
		$d->tooltip('Rank: #val#');

		$line = new line();
		$line->set_default_dot_style($d);
		$line->set_values( $team->rankings );
		$line->set_width( (int) $config['line1_strength'] );
		$line->set_key($team->name, 12);
		$line->set_colour( $config['line1'] );
		$line->on_show(new line_on_show($config['l_animation_1'], $config['l_cascade_1'], $config['l_delay_1']));
		$chart->add_element($line);

		//load team2, second team in the dropdown
		$team = $this->team2; 
		$d = new $config['dotstyle_2']();
		$d->size((int) $config['line2_dot_strength']);
		$d->halo_size(1);
		$d->colour($config['line2']);
		$d->tooltip('Rank: #val#');

		$line = new line();
		$line->set_default_dot_style($d);
		$line->set_values( $team->rankings );
		$line->set_width( (int) $config['line2_strength'] );
		$line->set_key($team->name, 12);
		$line->set_colour( $config['line2'] );
		$line->on_show(new line_on_show($config['l_animation_2'], $config['l_cascade_2'], $config['l_delay_2']));
		$chart->add_element($line);
			
		$x = new x_axis();
		if ($config['x_axis_label']==1)
		{
			$xlabels = new x_axis_labels();
			$xlabels->set_labels($round_labels);
			$xlabels->set_vertical();
		}
		$x->set_labels($xlabels);
		$x->set_colours($config['x_axis_colour'], $config['x_axis_colour_inner']);
		$chart->set_x_axis( $x );
		$x_legend = new x_legend( JText::_('COM_SPORTSMANAGEMENT_CURVE_ROUNDS') );
		$x_legend->set_style( '{font-size: 15px; color: #778877}' );
		$chart->set_x_legend( $x_legend );

		$y = new y_axis();
		$y->set_range( count($data), 1, -1);
		$y->set_colours($config['x_axis_colour'], $config['x_axis_colour_inner']);
		$chart->set_y_axis( $y );
		$y_legend = new y_legend( JText::_('COM_SPORTSMANAGEMENT_CURVE_RANK') );
		$y_legend->set_style( '{font-size: 15px; color: #778877}' );
		$chart->set_y_legend( $y_legend );
		
		ob_clean();
		echo $chart->toString(); 
	}
}

/**
 * hline()
 * 
 * @param mixed $color
 * @param mixed $length
 * @param mixed $ypoint
 * @param mixed $linewidth
 * @return
 */
function hline($color, $length, $ypoint, $linewidth)
{
	$hline = new shape( $color );
	$hline->append_value( new shape_point( -0.5, $ypoint) );
	$hline->append_value( new shape_point( -0.5, $ypoint + $linewidth ) );
	$hline->append_value( new shape_point( $length, $ypoint + $linewidth) );
	$hline->append_value( new shape_point( $length, $ypoint ) );
	return $hline;
}

?>