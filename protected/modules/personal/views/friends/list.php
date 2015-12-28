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
                <li class="active"><a>Все друзья</a></li>
                <li class="pull-right"><a href="<?php echo $this->createUrl("denied") ?>">Отклоненные</a></li>
                <li class="pull-right"><a href="<?php echo $this->createUrl("pending") ?>">В ожидании</a></li>
            </ul>
            <?php
            $f = UsersFriends::model()->with("u1", "u2")->approved()->getUserFriends(Yii::app()->user->id);
            $online = [];
            $offline = [];
            foreach ($f as $item) {
                if ($item->first_user == Yii::app()->user->id) {
                    if (Yii::app()->redis->get("online_" . mb_strtolower($item->u2->username))) {
                        $online[] = $item->u2->id;
                    } else {
                        $offline[] = $item->u2->id;
                    }
                } else {
                    if (Yii::app()->redis->get("online_" . mb_strtolower($item->u1->username))) {
                        $online[] = $item->u1->id;
                    } else {
                        $offline[] = $item->u1->id;
                    }
                }
            }
            ?>
            <div class="row">
                <div class="col-md-12 list" style="padding: 20px">
                    <h4>Друзья онлайн</h4>
                    <?php
                    foreach ($online as $item) {
                        echo Users::model()->getUsernameAvatarWithLink($item, 48);
                    }
                    ?>
                    <h4>Друзья оффлайн</h4>
                    <?php
                    foreach ($offline as $item) {
                        echo Users::model()->getUsernameAvatarWithLink($item, 48);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>