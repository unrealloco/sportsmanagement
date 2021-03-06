<?php 
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      editlineup_players_trikot_numbers.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage match
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
/*
echo 'starters<pre>'.print_r($this->starters,true).'</pre><br>';
echo 'positions<pre>'.print_r($this->positions,true).'</pre><br>';
echo 'substitutions<pre>'.print_r($this->substitutions,true).'</pre><br>';
*/

?>
<fieldset class="adminform">
<legend><?php echo Text::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_ELUP_TRIKOT_NUMBER'); ?></legend>
<?php    
if ( $this->positions )
{
foreach ($this->positions AS $position_id => $pos)
		{
		?>
<fieldset class="adminform">
<legend><?php echo Text::_($pos->text); ?></legend>
<table>    
    <?PHP
    // get players assigned to this position
    foreach ($this->starters[$position_id] AS $player)
		{
		//echo ''.$player->firstname.'-'.$player->lastname.'-'.$player->jerseynumber.'-'.$player->trikot_number.'<br>';
		?>
		<tr>
		
    <td><?php echo $player->firstname; ?>
    </td>
    
    <td><?php echo $player->lastname; ?>
    </td>
    
    <td><?php echo $player->jerseynumber; ?>
    </td>
    
    <td><input type='' name='trikot_number[<?php echo $player->value;?>]' value="<?php echo $player->trikot_number; ?>" />
    </td>
<td>
<?PHP    
    $append=' style="background-color:#bbffff"';
									echo HTMLHelper::_(	'select.genericlist',
													$this->lists['captain'],
													'captain['.$player->value.']',
													'class="inputbox" size="1" '.$append,
													'value','text',$player->captain);
?> 
</td>                                                   	
		</tr>
		<?PHP
    }
		
    ?>
    </table>
    </fieldset>   
    <?PHP	
		}
	}

?>      
</fieldset>      
