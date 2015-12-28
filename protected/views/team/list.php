<div class="staff">

    <?php $this->renderPartial('application.views.partial.breadcrumbs'); ?>
    <h1 class="title">Команда проекта</h1>

    <div style="padding: 0 30px;">
        <?php
        $admins = Users::model()->findAllByAttributes(["rang" => 1]);
        ?>
        <h3 style="color: darkred">Администраторы
            <small><?php echo count($admins); ?></small>
        </h3>
        <hr/>
        <div class="row">
            <?php
            /**
             * @var $item Users
             */
            foreach ($admins as $item) {
                ?>
                <div class="col-md-2">
                    <a class="thumbnail" href="<?php echo $item->getProfileLink(); ?>">
                        <img class="avatar" src="<?php echo $item->getAvatarLink($item->username, 152); ?>"
                             alt="<?php echo $item->username ?>"
                             title="<?php echo $item->username ?>" rel="tooltip" width="152"
                             height="152"
                             style="width: 152px; height: 152px; ">
                    </a>
                </div>
            <?php
            }
            ?>
        </div>

        <?php
        $moders = Users::model()->findAllByAttributes(["rang" => 2]);
        ?>
        <h3 style="color: darkgreen">Модераторы
            <small><?php echo count($moders); ?></small>
        </h3>
        <hr/>
        <div class="row">
            <?php
            /**
             * @var $item Users
             */
            foreach ($moders as $item) {
                ?>
                <div class="col-md-2">
                    <a class="thumbnail" href="<?php echo $item->getProfileLink(); ?>">
                        <img class="avatar" src="<?php echo $item->getAvatarLink($item->username, 152); ?>"
                             alt="<?php echo $item->username ?>"
                             title="<?php echo $item->username ?>" rel="tooltip" width="152"
                             height="152"
                             style="width: 152px; height: 152px; ">
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>