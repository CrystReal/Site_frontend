<?php
/**
 * @var $model Users
 */
?>
<div class="profile">
<div class="row">
    <div class="col-md-12">
        <?php ErrInfo::alerts(); ?>
        <h2><?php echo $model->username; ?></h2>

        <?php
        echo $model->getOnline();
        ?>

        <?php
        if (!Yii::app()->user->isGuest && Yii::app()->user->getId() != $model->id) {
            /**
             * @var $fr UsersFriends
             */
            $fr = UsersFriends::model()->getFriendship(Yii::app()->user->getId(), $model->id);
            if ($fr) {
                if ($fr->approved == UsersFriends::APPROVED) {
                    ?>
                    <div class="btn-group actions">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Вы уже друзья <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="<?php echo $this->createUrl("/personal/friends/DeleteFriend", ["id" => $model->id]); ?>"
                                   class="text-bold">Удалить из друзей</a></li>
                        </ul>
                    </div>
                <?php
                } elseif ($fr->first_user == Yii::app()->user->getId()) {
                    if ($fr->approved == UsersFriends::WAITING) {
                        ?>
                        <div class="btn-group actions">
                            <button type="button" class="btn btn-primary disabled"> Запрос на дружбу отправлен</button>
                            <button type="button" class="btn btn-primary dropdown-toggle"
                                    data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo $this->createUrl("/personal/friends/DeleteFriend", ["id" => $model->id]); ?>" class="text-bold">Отменить</a></li>
                            </ul>
                        </div>
                    <?php
                    } else {
                        ?>
                        <div class="btn-group actions">
                            <button type="button" class="btn btn-primary dropdown-toggle disabled"
                                    data-toggle="dropdown">
                                Запрос на дружбу отправлен <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="disabled text-bold">Отменить</a></li>
                            </ul>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="btn-group actions">
                        <button type="button" class="btn btn-primary disabled">Ответить на запрост дружбы</button>
                        <button type="button" class="btn btn-primary dropdown-toggle"
                                data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo $this->createUrl("/personal/friends/addFriend", ["id" => $model->id]); ?>" class="text-bold">Принять</a></li>
                            <li><a href="<?php echo $this->createUrl("/personal/friends/declineFriend", ["id" => $model->id]); ?>" class="text-bold">Отклонить</a></li>
                        </ul>
                    </div>
                <?php
                }
            } else {
                ?>
                <a class="actions btn btn-primary" href="<?php echo $this->createUrl("/personal/friends/addFriend", ["id" => $model->id]); ?>">Добавить в друзья</a>
            <?php
            }
        } ?>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <a class="thumbnail">
            <?php echo Users::model()->getAvatar($model->username, 200); ?>
        </a>

        <p class="text-center">
            <?php echo $model->getBadges(); ?>
        </p>
    </div>
    <div class="col-md-2">
        <h4>Убийства <span>Всего <?php echo $model->getTotalKills(); ?></span></h4>

        <div class="headsList">
            <?php
            $i = 0;
            foreach ($model->getLastKills() as $item) {
                if ($i == 20) break;
                echo Users::model()->getUsernameAvatarWithLink($item['id'], 28);
                $i++;
            }
            ?>
        </div>
    </div>
    <div class="col-md-2">
        <h4>Смерти <span>Всего <?php echo $model->getTotalDeaths(); ?></span></h4>

        <div class="headsList">
            <?php
            $i = 0;
            foreach ($model->getLastDeaths() as $item) {
                if ($i == 20) break;
                echo Users::model()->getUsernameAvatarWithLink($item['id'], 28);
                $i++;
            }
            ?>
        </div>
    </div>
    <div class="col-md-2">
        <h4>Друзья <span>Всего <?php echo $model->getTotalFriends(); ?></span></h4>

        <div class="headsList">
            <?php
            $i = 1;
            foreach ($model->getFriends() as $item) {
                if ($i == 21)
                    break;
                echo Users::model()->getUsernameAvatarWithLink($item['id'], 28);
                $i++;
            }
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <h4>Суммарная статистика</h4>

        <div class="totalStats">
            <h3>
                <small>Вошел</small>
                <?php echo $i = $model->getTotalJoins(); ?>
                <small> <?php echo AlexBond::doPlural($i, "раз", "раза", "раз"); ?></small>
            </h3>
            <h3>
                <small>Соотношение У/С</small>
                <?php echo $model->getKDRatio(); ?>
            </h3>
            <h3>
                <?php echo $model->getWinPerc(); ?>%
                <small> побед</small>
            </h3>
            <h3>
                <small>Сыграл</small>
                <?php echo $i = $model->getTotalGames(); ?>
                <small> <?php echo AlexBond::doPlural($i, "игру", "игры", "игр"); ?></small>
            </h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#inform" data-toggle="tab">О <?php echo $model->username; ?></a></li>
            <li class=""><a href="#pvp" data-toggle="tab">PVP события</a></li>
            <li class=""><a href="#bans" data-toggle="tab">Наказания</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="inform">
                <div class="row profileLinks">
                    <?php
                    if (!empty($model->vk_link))
                        $this->renderPartial("partial/_profileLink", ["header" => "ВКонтакте", "link" => $model->vk_link]);
                    if (!empty($model->fb_link))
                        $this->renderPartial("partial/_profileLink", ["header" => "Facebook", "link" => $model->fb_link]);
                    if (!empty($model->yt_link))
                        $this->renderPartial("partial/_profileLink", ["header" => "YouTube", "link" => $model->yt_link]);
                    if (!empty($model->twitter_link))
                        $this->renderPartial("partial/_profileLink", ["header" => "Twitter", "link" => $model->twitter_link]);
                    ?>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h6>Пол</h6>
                        <pre><?php echo $model->getSexOptions()[$model->sex]; ?></pre>
                    </div>
                    <?php if (!empty($model->location)) { ?>
                        <div class="col-md-4">
                            <h6>Раположение</h6>
                            <pre><?php echo $model->location; ?></pre>
                        </div>
                    <?php } ?>
                    <?php if (!empty($model->birthday) && strtotime($model->birthday) > 0) { ?>
                        <div class="col-md-4">
                            <h6>Дата рождения</h6>
                            <pre><?php echo $model->getBirthday(); ?></pre>
                        </div>
                    <?php } ?>
                </div>
                <?php if (!empty($model->interests)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Интересы</h6>
                            <pre><?php echo $model->interests; ?></pre>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($model->about)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>О себе</h6>
                                <pre><?php
                                    $p = new CHtmlPurifier();
                                    echo $p->purify($model->about);
                                    ?></pre>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tab-pane fade" id="pvp" style="padding: 20px">
                <div class="row">
                    <?php $data = $model->getLastKillsAndDeaths(); ?>
                    <div class="col-md-6">
                        <?php
                        $i = 1;
                        foreach ($data as $key => $item) {
                            echo "<p>";
                            if ($item['by'] == $model->id)
                                echo Users::model()->getUsernameAvatarWithLink($model->id, 16) . " убил " . Users::model()->getUsernameWithAvatarAndLink($item['to'], 16);
                            else
                                echo Users::model()->getUsernameWithAvatarAndLink($item['by'], 16) . " убил " . Users::model()->getUsernameAvatarWithLink($model->id, 16);
                            echo " в " . CHtml::link(Yii::app()->params['gameTypes'][$item['in']]["name"], Yii::app()->createUrl("/stats/" . Yii::app()->params['gameTypes'][$item['in']]["url"] . "/view", ["id" => $item['inId']]));
                            echo " <span rel='tooltip' title='" . date("d.m.Y H:m:i", $item['when']) . "'>" . AlexBond::time_since(time() - $item['when']) . "</span>";
                            echo "</p>";
                            unset($data[$key]);
                            if ($i == 25)
                                break;
                            $i++;
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        $i = 1;
                        foreach ($data as $key => $item) {
                            echo "<p>";
                            if ($item['by'] == $model->id)
                                echo Users::model()->getUsernameAvatarWithLink($model->id, 16) . " убил " . Users::model()->getUsernameWithAvatarAndLink($item['to'], 16);
                            else
                                echo Users::model()->getUsernameWithAvatarAndLink($item['by'], 16) . " убил " . Users::model()->getUsernameAvatarWithLink($model->id, 16);
                            echo " в " . CHtml::link(Yii::app()->params['gameTypes'][$item['in']]["name"], Yii::app()->createUrl("/stats/" . Yii::app()->params['gameTypes'][$item['in']]["url"] . "/view", ["id" => $item['inId']]));
                            echo " <span rel='tooltip' title='" . date("d.m.Y H:m:i", $item['when']) . "'>" . AlexBond::time_since(time() - $item['when']) . "</span>";
                            echo "</p>";
                            unset($data[$key]);
                            if ($i == 25)
                                break;
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="bans">
                <?php
                $bans = BanLog::model()->getLogOfUser($model->id);
                if (count($bans) == 0) {
                    echo '<h3 style="text-align: center">Да у нас тут ангелочек!</h3>';
                } else {
                    ?>
                    <br/>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Администратор</th>
                            <th style="width: 40%;">Причина</th>
                            <th>Тип</th>
                            <th>Дата истечения</th>
                            <th>Дата</th>
                        </tr>
                        </thead>
                        <?php
                        foreach ($bans as $item) {
                            ?>
                            <tr>
                                <td><?php echo Users::model()->getUsernameWithAvatarAndLink($item->admin_id, 18); ?></td>
                                <td><?php echo $item->reason; ?></td>
                                <td><?php echo $item->getTypeWithColorString(); ?></td>
                                <td><?php echo $item->getTermString(); ?></td>
                                <td><?php echo $item->getDateWithTooltip(); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>