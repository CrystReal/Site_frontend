<?php
/**
 * @var $item BsStatsPlayers
 */
?>
<tr>
    <td><?php echo $item->position ?></td>
    <td><?php echo Users::model()->getUsernameWithLink($item->playerId); ?></td>
    <td><?php echo $item->shots ?></td>
    <td><?php echo AlexBond::secToTime($item->timeInGame); ?></td>
</tr>