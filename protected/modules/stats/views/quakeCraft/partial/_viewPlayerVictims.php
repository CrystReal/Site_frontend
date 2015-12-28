<?php
/**
 * @var $item QcStatsPlayers
 */
?>
<div class="modal fade" id="victims<?php echo $item->id; ?>" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    Жертвы <?php echo Users::model()->getUsernameWithLink($item->playerId); ?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tr>
                        <th>Ник</th>
                        <th>Время</th>
                    </tr>
                    <?php
                    foreach ($item->getVictims() as $itemA) {
                        ?>
                        <tr>
                            <td><?php echo Users::model()->getUsernameWithLink($itemA->victim); ?></td>
                            <td><?php echo date("j.n.Y G:i:s", $itemA->time); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->