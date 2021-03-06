<?php  
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      edit_matchextended.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage editmatch
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
use Joomla\CMS\Language\Text;
foreach ($this->extended->getFieldsets() as $fieldset)
{
	?>
	<fieldset class="adminform">
	<legend><?php echo Text::_($fieldset->name); ?></legend>
	<?php
	$fields = $this->extended->getFieldset($fieldset->name);
	
	if(!count($fields)) {
		echo Text::_('COM_SPORTSMANAGEMENT_GLOBAL_NO_PARAMS');
	}
	
	foreach ($fields as $field)
	{
		echo $field->label;
       	echo $field->input;
	}
	?>
	</fieldset>
	<?php
}
?>
