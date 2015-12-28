<?php
/**
 * @var $model DkStatsGames
 */
?>
<div class="stats defkill view">
    <div class="row">
        <div class="col-md-12">
            <h2>DefKill <span><i class="fa fa-chevron-right"></i></span> Бой <?php echo $model->id; ?></h2>

            <div class="back"><a href="<?php echo $this->createUrl("list"); ?>">Назад к списку боев <i
                        class="fa fa-arrow-right"></i></a></div>

            <div class="row">
                <div class="col-md-12 text-center winner">
                    <h4>Победила</h4>
                    <?php
                    switch ($model->winner) {
                        case 1:
                            echo '<span class="team" style="color: darkred">КРАСНАЯ КОМАНДА</span>';
                            break;
                        case 2:
                            echo '<span class="team" style="color: darkblue">СИНЯЯ КОМАНДА</span>';
                            break;
                        case 3:
                            echo '<span class="team" style="color: darkgreen">ЗЕЛЕНАЯ КОМАНДА</span>';
                            break;
                        case 4:
                            echo '<span class="team" style="color: #b0b000">ЖЕЛТАЯ КОМАНДА</span>';
                            break;
                    }
                    if ($model->winType == 0) {
                        echo '(Нексусы противников уничтожены)';
                    } else {
                        echo '<span rel="tooltip" title="Все игроки противников покинули игру.">(Техническая победа)</span>';
                    }
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
    <?php
    $teams = [
        "red" => [],
        "blue" => [],
        "green" => [],
        "yellow" => []
    ];
    foreach ($model->players as $item) {
        switch ($item->team) {
            case 1:
                $teams['red'][] = $item;
                break;
            case 2:
                $teams['blue'][] = $item;
                break;
            case 3:
                $teams['green'][] = $item;
                break;
            case 4:
                $teams['yellow'][] = $item;
                break;
        }
    }
    ?>
    <div class="row">
        <div class="col-md-6 team">
            <h4>Красная команда</h4>
            <?php
            $this->renderPartial("partial/_viewTeam", ["team" => $teams['red']]);
            ?>
        </div>
        <div class="col-md-6 team">
            <h4>Синяя команда</h4>
            <?php
            $this->renderPartial("partial/_viewTeam", ["team" => $teams['blue']]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 team">
            <h4>Зеленая команда</h4>
            <?php
            $this->renderPartial("partial/_viewTeam", ["team" => $teams['green']]);
            ?>
        </div>
        <div class="col-md-6 team">
            <h4>Желтая команда</h4>
            <?php
            $this->renderPartial("partial/_viewTeam", ["team" => $teams['yellow']]);
            ?>
        </div>
    </div>
</div>