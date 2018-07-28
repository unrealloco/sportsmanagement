<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      default.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage mod_sportsmanagement_teamstats_ranking
 */

/**
 * no direct access
 */
defined('_JEXEC') or die('Restricted access');

/**
 * check if any results returned
 */
$items = count($list['ranking']);
if (!$items) {
   echo '<p class="bg-danger">' . JText::_('MOD_SPORTSMANAGEMENT_TEAMSTATS_RANKING_NO_ITEMS') . '</p>';
   return;
}

$teamnametype = $params->get('teamnametype', 'short_name');

//echo '<pre>';print_r($list); echo '</pre>';exit;
//echo '<pre>';print_r($list['ranking']); echo '</pre>';exit;
?>

<div class="row">

<?php if ($params->get('show_project_name', 0)):?>
<p class="projectname"><?php echo $list['project']->name; ?></p>
<?php endif; ?>

<table class="<?php echo $params->get('table_class','table'); ?>">
	<thead>
		<tr class="sectiontableheader">
			<th class="rank"><?php echo JText::_('MOD_SPORTSMANAGEMENT_TEAMSTATS_RANKING_COL_RANK')?></th>
			<th class="teamlogo"></th>
			<th class="team"><?php echo JText::_('MOD_SPORTSMANAGEMENT_TEAMSTATS_RANKING_COL_TEAM')?></th>
			<th class="td_c">
			<?php
			if ($params->get('show_event_icon', 1))
			{
				echo modSportsmanagementTeamStatHelper::getStatIcon($list['stat']);
			}
			else
			{
				echo JText::_($list['stat']->name);
			}
			?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$lastRank = 0;
	$k = 0;
	foreach (array_slice($list['ranking'], 0, $params->get('limit', 5)) as $item) :  ?>
		<?php $team = $list['teams'][$item->team_id]; ?>
		<?php
			$class = $params->get('style_class2', 0);;
			if ( $k == 0 ) { $class = $params->get('style_class1', 0);}
		?>	
		<tr class="<?php echo $class; ?>">
			<td class="rank">
			<?php 
				$rank = ($item->rank == $lastRank) ? "-" : $item->rank;
				$lastRank = $item->rank;
				echo $rank; 
			?>
			</td>
			<td class="teamlogo">
				<?php if ($params->get('show_logo', 0)): ?>
				<?php echo modSportsmanagementTeamStatHelper::getLogo($team, $params->get('show_logo', 0)); ?>
				<?php endif; ?>			
			</td>
			<td class="team">
				<?php if ($params->get('teamlink', '')): ?>
				<?php echo JHTML::link(modSportsmanagementTeamStatHelper::getTeamLink($team, $params, $list['project']), $team->$teamnametype); ?>
				<?php else: ?>
				<?php echo $team->$nametype; ?>
				<?php endif; ?>
			</td>
			<td class="td_c"><?php echo $item->total; ?></td>
		</tr>
	<?php $k=(1-$k); ?>	
	<?php endforeach; ?>
	</tbody>
</table>

</div>