<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      editstats.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage match
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

// welche joomla version ?
if(version_compare(JVERSION,'3.0.0','ge')) 
{
HTMLHelper::_('jquery.framework');
}

HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.formvalidation');
$params = $this->form->getFieldsets('params');

//echo 'sportsmanagementViewMatch _displayEditStats teams<br><pre>'.print_r($this->teams,true).'</pre>';

?>
<?php
//save and close 
$close = Factory::getApplication()->input->getInt('close',0);
if($close == 1) {
	?><script>
	window.addEvent('domready', function() {
		$('cancel').onclick();	
	});
	</script>
	<?php 
}
?>
<form  action="<?php echo JRoute::_('index.php?option=com_sportsmanagement');?>" id='adminform' method='post' style='display:inline' name='adminform' >
<!--	<div id="jlstatsform"> -->
<!--	<fieldset> -->
		<div class="fltrt">
			<button type="button" onclick="Joomla.submitform('matches.savestats', this.form);">
				<?php echo Text::_('JAPPLY');?></button>
			<button type="button" onclick="$('close').value=1; Joomla.submitform('matches.savestats', this.form);">
				<?php echo Text::_('JSAVE');?></button>
			
		</div>
		<div class="configuration" >
			Stats
		</div>
<!--	</fieldset> -->
	<div class="clear"></div>
		<?php
// Define tabs options for version of Joomla! 3.1
$tabsOptionsJ31 = array(
            "active" => "panel1" // It is the ID of the active tab.
        );
echo HTMLHelper::_('bootstrap.startTabSet', 'ID-Tabs-J31-Group', $tabsOptionsJ31);
echo HTMLHelper::_('bootstrap.addTab', 'ID-Tabs-J31-Group', 'panel1', Text::_($this->teams->team1) );	
echo $this->loadTemplate('home');	
echo HTMLHelper::_('bootstrap.endTab');
echo HTMLHelper::_('bootstrap.addTab', 'ID-Tabs-J31-Group', 'panel2', Text::_($this->teams->team2) );	
echo $this->loadTemplate('away');	
echo HTMLHelper::_('bootstrap.endTab');	
echo HTMLHelper::_('bootstrap.endTabSet'); 
		
		?>
		
		<input type="hidden" name="view" value="" />
		
		<input type="hidden" name="close" id="close" value="0" />
		<input type="hidden" name="task" id="" value="" />
		<input type="hidden" name="project_id"	value="<?php echo $this->project_id; ?>" />
		<input type="hidden" name="id"	value="<?php echo $this->item->id; ?>" />
        <input type="hidden" name="match_id"	value="<?php echo $this->item->id; ?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="component" value="com_sportsmanagement" />
		<?php echo HTMLHelper::_( 'form.token' ); ?>
<!--	</div> -->
</form>
<div style="clear: both"></div>
