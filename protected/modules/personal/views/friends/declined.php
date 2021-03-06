<div class="friends">
    <?php $this->renderPartial('application.views.partial.breadcrumbs'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php ErrInfo::alerts(null); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Друзья</h2>
            <hr/>
            <ul class="nav nav-tabs">
                <li><a href="<?php echo $this->createUrl("friends") ?>">Все друзья</a></li>
                <li class="active pull-right"><a>Отклоненные</a></li>
                <li class="pull-right"><a href="<?php echo $this->createUrl("pending") ?>">В ожидании</a></li>
            </ul>
            <div class="row">
                <div class="col-md-12" style="padding: 20px">
                    <?php
                    $f = UsersFriends::model()->declined()->getUserFriends(Yii::app()->user->id);
                    if (count($f) > 0) {
                        ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="40%">Друг</th>
                                <th width="30%">Действие</th>
                                <th width="30%">Отказано в</th>
                            </tr>
                            </thead>
                            <?php foreach ($f as $item) {
                                ?>
                                <tr>
                                    <td><?php
                                        if ($item->first_user == Yii::app()->user->id)
                                            echo Users::model()->getUsernameWithAvatarAndLink($item->second_user, 15);
                                        else
                                            echo Users::model()->getUsernameWithAvatarAndLink($item->first_user, 15);
                                        ?></td>
                                    <td>
                                        <?php
                                        if ($item->first_user != Yii::app()->user->id) {
                                            echo '<a class="btn btn-xs btn-success" href="' . $this->createUrl("addFriend", ["id" => $item->first_user]) . '">Принять</a>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date("d.m.Y H:m:i", $item->since) ?>
                                    </td>
                                </tr>
                            <?php
                            } ?>
                        </table>
                    <?php
                    } else {
                        echo "<p>Нет отказников.</p>";
                    }?>
                </div>
            </div>
        </div>
    </div>
</div>