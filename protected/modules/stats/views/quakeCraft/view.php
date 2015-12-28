<?php
/**
 * @var $model QcStatsGames
 */
?>
<div class="stats quakecraft view">
    <div class="row">
        <div class="col-md-12">
            <h2>QuakeCraft <span><i class="fa fa-chevron-right"></i></span> Бой <?php echo $model->id; ?></h2>

            <div class="back"><a href="<?php echo $this->createUrl("list"); ?>">Назад к списку боев <i
                        class="fa fa-arrow-right"></i></a></div>

            <div class="row">
                <div class="col-md-12 text-center winner">
                    <h4>Победил</h4>
                    <?php
                    echo '<span>' . Users::model()->getUsernameWithLink($model->winnerId) . '</span>';
                    ?>

                </div>
            </div>
            <div class="row text-center text-bold">
                <div class="col-md-4">
                    <h4>Сервер</h4>
                    <?php echo $model->getServerName(); ?>
                </div>
                <div class="col-md-4">
                    <h4>Карта</h4>
                    <?php echo $model->getMapName(); ?>
                </div>
                <div class="col-md-4">
                    <h4>Время игры</h4>
                    <span
                        title="<?php echo date("j.n.Y G:i:s", $model->start) . " - " . date("j.n.Y G:i:s", $model->end); ?>"
                        rel="tooltip"><?php echo AlexBond::secToTime($model->end - $model->start); ?></span>
                </div>
            </div>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-condensed table-bordered">
                <tr>
                    <th>Ник</th>
                    <th>Убийств</th>
                    <th>Смертей</th>
                    <th>Выстрелов</th>
                    <th>Время в игре</th>
                </tr>
                <?php
                $players = [];
                $leaved = [];
                /**
                 * @var $item QcStatsPlayers
                 */
                foreach ($model->players as $item) {
                    if (!$item->tillFinish)
                        $players[] = [
                            "kills" => $item->kills,
                            "model" => $item
                        ];
                    else
                        $leaved[] = [
                            "kills" => $item->kills,
                            "model" => $item
                        ];
                }
                $players = AlexBond::record_sort($players, "kills", true);
                $leaved = AlexBond::record_sort($leaved, "kills", true);

                foreach ($players as $item)
                    $this->renderPartial("partial/_viewPlayer", ["item" => $item["model"]]);
                foreach ($leaved as $item)
                    $this->renderPartial("partial/_viewPlayer", ["item" => $item["model"]]);
                ?>
            </table>

        </div>
    </div>
</div>
<?php
foreach ($model->players as $item) {
    $this->renderPartial("partial/_viewPlayerVictims", ["item" => $item]);
}
?>