<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      default_results_all.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage allprojectrounds
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

?>

<!-- Main START -->
<div class="row-fluid" id="">

<!-- content -->
<?php

	?>
	<table class="<?php echo $this->tableclass;?>">
		<tr>
			<td class="">
				<?php
					//get the division name from the first team of the division 
					echo $this->content;
				?>
			</td>
		</tr>
	</table>
	
	<?php

	?>
<!-- all results END -->

</div>

