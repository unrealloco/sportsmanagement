<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      pagination.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage helpers
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

/**
 * sportsmanagementPagination
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementModelPagination extends BaseDatabaseModel
{
    public static $nextlink = '';
    public static $prevlink = '';

	
    /**
     * sportsmanagementModelPagination::getnextlink()
     * 
     * @return
     */
    function getnextlink()
    {
       $app = Factory::getApplication();
$option = $app->input->getCmd('option');	    
        if ( COM_SPORTSMANAGEMENT_SHOW_DEBUG_INFO )
       {
        $my_text = 'nextink -> '.$this->nextlink.'<br>'; 
//        sportsmanagementHelper::$_success_text[__METHOD__][__FUNCTION__]['class'] = __CLASS__;
//        sportsmanagementHelper::$_success_text[__METHOD__][__FUNCTION__]['zeile'] = __LINE__;
//        sportsmanagementHelper::$_success_text[__METHOD__][__FUNCTION__]['text'] = $my_text;
        sportsmanagementHelper::setDebugInfoText(__METHOD__,__FUNCTION__,__CLASS__,__LINE__,$my_text);
        }
        
        return $this->nextlink;
    }
    
    /**
	 * create and return the round page navigation
	 *
	 * @param object $project
	 * @return string
	 */
	public static function pagenav($project,$cfg_which_database = 0,$s=0)
	{
       $app = Factory::getApplication();
		$option = $app->input->getCmd('option');	    
       // JInput object
        $jinput = $app->input;
        
		$pageNav = '';
		$spacer2 = '&nbsp;&nbsp;';
		$spacer4 = '&nbsp;&nbsp;&nbsp;&nbsp;';
		$roundid = $app->input->getInt( "r", $project->current_round);
		$mytask = $app->input->getVar('task','','request','word');
		$view = $app->input->getVar('view','','request','word');
		$layout = $app->input->getVar('layout','','request','word');
		$controller = $app->input->getVar('controller');
		$divLevel = $app->input->getInt('divLevel',0);
		$division = $jinput->request->get('division','0', 'STR');
		$firstlink = '';
		$lastlink = '';
        
        if (empty($roundid) )
        {
            $roundid = $project->current_round;
        }
        
       
		$firstRound	= sportsmanagementModelRounds::getFirstRound($project->id,$cfg_which_database);
		$lastRound = sportsmanagementModelRounds::getLastRound($project->id,$cfg_which_database);
		$previousRound = sportsmanagementModelRounds::getPreviousRound($roundid, $project->id,$cfg_which_database);
		$nextRound = sportsmanagementModelRounds::getNextRound($roundid, $project->id,$cfg_which_database);
		$currentRoundcode = sportsmanagementModelRound::getRoundcode($roundid,$cfg_which_database);
		$arrRounds = sportsmanagementModelRounds::getRoundsOptions($project->id,'ASC',$cfg_which_database);
		$rlimit	= count($arrRounds);

		$params = array();
		$params['option'] = $option;
		if ($view){$params['view'] = $view;}
        
        $params['cfg_which_database']= $cfg_which_database;
        $params['s']= $s;
        
		$params['p'] = $project->slug;
        
		if ($controller){$params['controller'] = $controller;}
		if ($layout){$params['layout'] = $layout;}
		if ($mytask){$params['task'] = $mytask;}
		if ($division > 0){$params['division'] = $division;}
		if ($divLevel > 0){$params['divLevel'] = $divLevel;}
		$prediction_id = Factory::getApplication()->input->getInt("prediction_id",0);
		if($prediction_id >0) 
        {
			$params['prediction_id']= $prediction_id;
		}
	
       
		$query = Uri::buildQuery($params);
		$link = Route::_('index.php?' . $query);
		$backward = sportsmanagementModelRound::getRoundId($currentRoundcode-1, $project->id,$cfg_which_database);
		$forward = sportsmanagementModelRound::getRoundId($currentRoundcode+1, $project->id,$cfg_which_database);

		if ($firstRound['id'] != $roundid)
		{
			$params['r'] = $backward;
            $params['division'] = $division;
            $params['mode'] = 0;
            $params['order'] = 0;
            
			$query = Uri::buildQuery($params);
			$link = Route::_('index.php?' . $query . '#'.$option.'_top');
            self::$prevlink = $link;
			$prevlink = HTMLHelper::link($link,Text::_('COM_SPORTSMANAGEMENT_GLOBAL_PREV'));
            


			$params['r'] = $firstRound['id'];
            $params['division'] = $division;
            $params['mode'] = 0;
            $params['order'] = 0;

			$query = Uri::buildQuery($params);
			$link = Route::_('index.php?' . $query . '#'.$option.'_top');
			$firstlink = HTMLHelper::link($link,Text::_('COM_SPORTSMANAGEMENT_GLOBAL_PAGINATION_START')) . $spacer4;
		}
		else
		{
			$prevlink = Text::_('COM_SPORTSMANAGEMENT_GLOBAL_PREV');
			$firstlink = Text::_('COM_SPORTSMANAGEMENT_GLOBAL_PAGINATION_START') . $spacer4;
		}
		
        if ($lastRound['id'] != $roundid)
		{
			$params['r'] = $forward;
            $params['division'] = $division;
            $params['mode'] = 0;
            $params['order'] = 0;

			$query = Uri::buildQuery($params);
			$link = Route::_('index.php?'.$query.'#'.$option.'_top');
            self::$nextlink = $link;
            
            
            
			$nextlink = $spacer4;
			$nextlink .= HTMLHelper::link($link,Text::_('COM_SPORTSMANAGEMENT_GLOBAL_NEXT'));

			$params['r'] = $lastRound['id'];
            $params['division'] = $division;
            $params['mode'] = 0;
            $params['order'] = 0;

			$query = Uri::buildQuery($params);
			$link = Route::_('index.php?' . $query . '#'.$option.'_top');
			$lastlink = $spacer4 . HTMLHelper::link($link,Text::_('COM_SPORTSMANAGEMENT_GLOBAL_PAGINATION_END'));
		}
		else
		{
			$nextlink = $spacer4 . Text::_('COM_SPORTSMANAGEMENT_GLOBAL_NEXT');
			$lastlink = $spacer4 . Text::_('COM_SPORTSMANAGEMENT_GLOBAL_PAGINATION_END');
		}
        
		$limit = count($arrRounds);
		$low = $currentRoundcode - 3;
		$high = $currentRoundcode + 3;
		for ($counter=1; $counter <= $limit; $counter++)
		{
				$round = $arrRounds[$counter-1];
				$roundcode = (int) $round->roundcode;
				if($roundcode < $low || $roundcode > $high) continue;
				if ( $roundcode < 10 )
				{
					$pagenumber = '0' . $roundcode;
				}
				else
				{
					$pagenumber = $roundcode;
				}
				if ($round->id != $roundid)
				{
					$params['r']= $round->value;
                    $params['division'] = $division;
            $params['mode'] = 0;
            $params['order'] = 0;

					$query		= Uri::buildQuery($params);
					$link		= Route::_('index.php?' . $query . '#'.$option.'_top');
					$pageNav   .= $spacer4 . HTMLHelper::link($link,$pagenumber);
				}
				else
				{
					$pageNav .= $spacer4 . $pagenumber;
				}
		}
        
        if ( COM_SPORTSMANAGEMENT_SHOW_DEBUG_INFO )
       {
        $my_text = 'firstlink -> '.$firstlink.'<br>' ;
        $my_text .= 'prevlink -> '.$prevlink.'<br>' ;
        $my_text .= 'nextlink -> '.$nextlink.'<br>' ;
        $my_text .= 'lastlink -> '.$lastlink.'<br>' ;
        sportsmanagementHelper::setDebugInfoText(__METHOD__,__FUNCTION__,__CLASS__,__LINE__,$my_text);
        }
        
		return '<span class="pageNav">&laquo;' . $spacer2 . $firstlink . $prevlink . $pageNav . $nextlink .  $lastlink . $spacer2 . '&raquo;</span>';
	}

	/**
	 * sportsmanagementModelPagination::pagenav2()
	 * 
	 * @param mixed $jl_task
	 * @param mixed $rlimit
	 * @param integer $currentRoundcode
	 * @param string $user
	 * @param string $mode
	 * @return
	 */
	function pagenav2($jl_task,$rlimit,$currentRoundcode=0,$user='',$mode='')
	{
	   $app = Factory::getApplication();
		$option = $app->input->getCmd('option');	    
		$mytask = $app->input->getVar('task',false);
		$divLevel = $app->input->getInt('divLevel',0);
		$division = $app->input->getInt('division',0);

		$pageNav2 = '<form action="" method="get" style="display:inline;">';
		$pageNav2 .= '<select class="inputbox" onchange="joomleague_changedoc(this)">';

		$params = array();
		$params['option'] = $option;
		$params['controller'] = $jl_task;
		$params['p'] = $this->projectid;
		if ($user){$params['uid'] = $user;}
		if ($mode){$params['mode'] = $mode;}
		if ($mytask){$params['task'] = $mytask;}
		if ($division > 0){$params['division'] = $division;}
		if ($divLevel > 0){$params['divLevel'] = $divLevel;}

		for ($counter=1; $counter <= $rlimit; $counter++)
		{
			if ($counter< 10){$pagenumber="0" . $counter;}else{$pagenumber = $counter;}
			if ($counter <= $rlimit)
			{
				$params['r'] = $counter;
				$query = Uri::buildQuery($params);
				$link  = Route::_('index.php?' . $query);

				$pageNav2 .= "<option value='".$link."'";
				if ($counter==$currentRoundcode)
				{
					$pageNav2 .= " selected='selected'";
				}
				$pageNav2 .= '>';
			}
			$pageNav2 .= $pagenumber . '</option>';
		}
		$pageNav2 .= '</select></form>';
		return $pageNav2;
	}

}
?>
