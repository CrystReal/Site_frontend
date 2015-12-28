<table class="table table-striped table-condensed table-bordered">
    <tr>
        <th>Ник</th>
        <th style="width: 30px">
            <img src="/static/images/icons/End_Stone_20.png" title="Урон нексусам"
                 rel="tooltip">
        </th>
        <th style="width: 30px; text-align: center">
            <img src="/static/images/icons/Village_Golem_20.png"
                 title="Убитых големов" rel="tooltip">
        </th>
        <th style="width: 30px">
            <img src="/static/images/icons/heart_20.png" title="Смертей" rel="tooltip">
        </th>
        <th style="width: 30px">
            <img src="/static/images/icons/iron_sword_20.png" title="Убийств"
                 rel="tooltip">
        </th>
        <th style="width: 30px">
            <img src="/static/images/icons/wood_20.png" title="Дерево" rel="tooltip">
        </th>
        <th style="width: 30px">
            <img src="/static/images/icons/coal_20.png" title="Уголь" rel="tooltip">
        </th>
        <th style="width: 30px">
            <img src="/static/images/icons/Iron_Ingot_20.png" title="Железо" rel="tooltip"></th>
        <th style="width: 30px">
            <img src="/static/images/icons/gold_20.png" title="Золото" rel="tooltip"></th>
        <th style="width: 30px">
            <img src="/static/images/icons/Diamond_20.png" title="Алмазы" rel="tooltip">
        </th>
    </tr>
    <?php
    $exit = [];
    foreach ($team as $item) {
        if ($item->tillFinish == 0) {
            $exit[] = $item;
            continue;
        }
        ?>
        <tr>
            <td><?php echo Users::model()->getUsernameWithLink($item->playerId); ?></td>
            <td><?php echo $item->nexusDamage; ?></td>
            <td><?php echo $item->killedGolems; ?></td>
            <td><?php echo $item->death; ?></td>
            <td> <a href="#victims<?php echo $item->id; ?>" data-toggle="modal"><?php echo count($item->victims); ?></a></td>
            <td><?php echo $item->ores->wood; ?></td>
            <td><?php echo $item->ores->coal; ?></td>
            <td><?php echo $item->ores->iron; ?></td>
            <td><?php echo $item->ores->gold; ?></td>
            <td><?php echo $item->ores->diamonds; ?></td>
        </tr>
    <?php
    }
    foreach ($exit as $item) {
        ?>
        <tr class="danger">
            <td><?php echo Users::model()->getUsernameWithLink($item->playerId); ?></td>
            <td><?php echo $item->nexusDamage; ?></td>
            <td><?php echo $item->killedGolems; ?></td>
            <td><?php echo $item->death; ?></td>
            <td> <a href="#victims<?php echo $item->id; ?>" data-toggle="modal"><?php echo count($item->victims); ?></a></td>
            <td><?php echo $item->ores->wood; ?></td>
            <td><?php echo $item->ores->coal; ?></td>
            <td><?php echo $item->ores->iron; ?></td>
            <td><?php echo $item->ores->gold; ?></td>
            <td><?php echo $item->ores->diamonds; ?></td>
        </tr>
    <?php
    }
    ?>
</table>
<?php
foreach ($team as $item) {
    $this->renderPartial("partial/_viewPlayerVictims", ["item" => $item]);
}
?>