<?php
/**
 * @var $item QcStatsPlayers
 */
?>
<tr <?php if ($item->tillFinish) echo 'class="danger"'; ?>>
    <td><?php echo Users::model()->getUsernameWithLink($item->playerId); ?></td>
    <td><?php echo $item->kills; ?> <a href="#victims<?php echo $item->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i></a>
    </td>
    <td><?php echo $item->deaths; ?></td>
    <td><?php echo $item->shots; ?></td>
    <td><?php echo AlexBond::secToTime($item->timeInGame); ?></td>
</tr>