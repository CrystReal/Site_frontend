<?php if (!Yii::app()->user->isGuest && Yii::app()->user->isForumAdmin()) {
    echo 'Админ: ' . CHtml::link('Новый форум', array('/forum/forum/create')) . '<br />';
}?>
<div class="sidebar">
    <ul class="nav nav-pills">
        <li <?php if ($menuItem == 0) echo ' class="active"'; ?>>
            <a href="<?php echo $this->createUrl("/forum/forum/index"); ?>"
               title="Последние темы">
                Последние темы
            </a>
        </li>
    </ul>
    <?php
    /**
     * @var $categories Forum[]
     * @var $sFs Forum[]
     */
    $categories = Forum::model()->cache(3600)->findAllByAttributes(["parent_id" => null]);
    foreach ($categories as $category) {
        ?>
        <h4><?php echo $category->title; ?></h4>
        <ul class="nav nav-pills">
            <?php
            $sFs = Forum::model()->cache(3600)->findAllByAttributes(["parent_id" => $category->id]);
            foreach ($sFs as $item) {
                ?>
                <li <?php if ($menuItem == $item->id) echo ' class="active"'; ?>>
                    <a href="<?php echo $item->getUrl(); ?>"
                       title="<?php echo $item->description; ?>">
                        <?php echo $item->title; ?>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    <?php
    }?>
</div>