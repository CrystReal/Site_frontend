<?php
/**
 * Created by Alex Bond.
 * Date: 18.01.14
 * Time: 18:12
 *
 * @var $data DkStatsGames[]
 */
$data = $dataProvider->getData();
?>
<div class="stats defkill list">
    <div class="row">
        <div class="col-md-12">
            <h2>Архив боев в DefKill</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-striped">
                <tr>
                    <th>ID</th>
                    <th>Номер сервера</th>
                    <th>Карта</th>
                    <th>Победитель</th>
                    <th>Тип победы</th>
                    <th>Длительность матча</th>
                    <th></th>
                </tr>
                <?php
                foreach ($data as $item) {
                    ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->getServerName(); ?></td>
                        <td><?php echo $item->getMapName(); ?></td>
                        <td class="winTeam"><?php echo $item->getWinnerTeam(); ?></td>
                        <td><?php echo $item->getWinType(); ?></td>
                        <td><?php echo AlexBond::secToTime($item->end - $item->start); ?></td>
                        <td>
                            <a class="btn btn-sm btn-default" href="<?php echo $this->createUrl("view", ["id" => $item->id]); ?>">Просмотреть</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>