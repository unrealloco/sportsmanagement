<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      default_history.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage nextmatch
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

?>
<!-- Start of show matches through all projects -->
<?php
if ($this->games) {
    ?>
<div class="<?php echo $this->divclassrow;?> table-responsive" id="nextmatch">
    <h4><?php echo Text::_('COM_SPORTSMANAGEMENT_NEXTMATCH_HISTORY'); ?></h4>
    <table class="<?php echo $this->config['hystory_table_class']; ?>">
        <tr>
            <td>
                <table class="<?php echo $this->config['hystory_table_class']; ?>">
                    <?php
                    //sort games by dates
                    $gamesByDate = Array();

                    $pr_id = 0;
                    $k = 0;
                    foreach ($this->games as $game) {
                        $gamesByDate[substr($game->match_date, 0, 10)][] = $game;
                    }
                    // $teams = $this->project->getTeamsFromMatches( $this->games );

                    foreach ($gamesByDate as $date => $games) {
                        foreach ($games as $game) {
                            if ($game->prid != $pr_id) {
                                ?>
                                <thead>
                                <tr class="sectiontableheader">
                                    <th colspan=10><?php echo $game->project_name; ?></th>
                                </tr>
                                </thead>
                                <?php
                                $pr_id = $game->prid;
                            }
                            ?>
                            <?php

                            $routeparameter = array();
                            $routeparameter['cfg_which_database'] = Factory::getApplication()->input->getInt('cfg_which_database', 0);
                            $routeparameter['s'] = Factory::getApplication()->input->getInt('s', 0);
                            $routeparameter['p'] = $game->project_slug;
                            $routeparameter['r'] = $game->round_slug;
                            $routeparameter['division'] = 0;
                            $routeparameter['mode'] = 0;
                            $routeparameter['order'] = '';
                            $routeparameter['layout'] = '';
                            $result_link = sportsmanagementHelperRoute::getSportsmanagementRoute('results', $routeparameter);

                            $routeparameter = array();
                            $routeparameter['cfg_which_database'] = Factory::getApplication()->input->getInt('cfg_which_database', 0);
                            $routeparameter['s'] = Factory::getApplication()->input->getInt('s', 0);
                            $routeparameter['p'] = $game->project_slug;
                            $routeparameter['mid'] = $game->match_slug;
                            $report_link = sportsmanagementHelperRoute::getSportsmanagementRoute('matchreport', $routeparameter);

                            $home = $this->gamesteams[$game->projectteam1_id];
                            $away = $this->gamesteams[$game->projectteam2_id];
                            ?>
                            <tr class="">
                                <td><?php
                                    echo HTMLHelper::link($result_link, $game->roundcode);
                                    ?></td>
                                <td class="nowrap"><?php
                                    echo HTMLHelper::date($date, Text::_('COM_SPORTSMANAGEMENT_MATCHDAYDATE'));
                                    ?></td>
                                <td><?php
                                    echo substr($game->match_date, 11, 5);
                                    ?></td>
                                <td class="nowrap"><?php
                                    echo $home->name;
                                    ?></td>

                                <td class="nowrap">
                                    <?php
                                    if (!sportsmanagementHelper::existPicture($home->picture)) {
                                        $home->picture = sportsmanagementHelper::getDefaultPlaceholder('logo_big');
                                    }

                                    echo sportsmanagementHelperHtml::getBootstrapModalImage('nextmatchprevh' . $game->id . '-' . $game->projectteam1_id,
                                        $home->picture,
                                        $home->name,
                                        '20',
                                        '',
                                        $this->modalwidth,
                                        $this->modalheight,
                                        $this->overallconfig['use_jquery_modal']);

                                    ?>
                                </td>

                                <td class="nowrap">-</td>

                                <td class="nowrap">
                                    <?php
                                    if (!sportsmanagementHelper::existPicture($away->picture)) {
                                        $away->picture = sportsmanagementHelper::getDefaultPlaceholder('logo_big');
                                    }
                                    echo sportsmanagementHelperHtml::getBootstrapModalImage('nextmatchprevh' . $game->id . '-' . $game->projectteam2_id,
                                        $away->picture,
                                        $away->name,
                                        '20',
                                        '',
                                        $this->modalwidth,
                                        $this->modalheight,
                                        $this->overallconfig['use_jquery_modal']);
                                    ?>
                                </td>

                                <td class="nowrap"><?php
                                    echo $away->name;
                                    ?></td>
                                <td class="nowrap"><?php
                                    echo $game->team1_result;
                                    ?></td>
                                <td class="nowrap"><?php echo $this->overallconfig['seperator']; ?></td>
                                <td class="nowrap"><?php
                                    echo $game->team2_result;
                                    ?></td>
                                <td class="nowrap"><?php
                                    if ($game->show_report == 1) {
                                        $desc = HTMLHelper::image(Uri::base() . "media/com_sportsmanagement/jl_images/zoom.png",
                                            Text::_('Match Report'),
                                            array("title" => Text::_('Match Report')));
                                        echo HTMLHelper::link($report_link, $desc);
                                    }
                                    $k = 1 - $k;
                                    ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </td>
        </tr>
    </table>
    </div>
    <!-- End of  show matches through all projects -->
    <?php
}
?>
