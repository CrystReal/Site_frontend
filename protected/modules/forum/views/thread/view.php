<?php
//$header = '<div class="preheader"><div class="preheaderinner">' . CHtml::encode($thread->subject) . '</div></div>';
$reply = $thread->is_locked && !Yii::app()->user->isForumAdmin() ? '' : CHtml::link("Ответить", array('/forum/thread/newreply', 'id' => $thread->id), ["class" => "btn btn-primary btn-sm pull-right"]);
?>

<div class="forum">
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $thread->getBreadcrumbs(),
        "htmlOptions" => ["class" => "breadcrumb"],
        'tagName' => 'ul', // will change the container to ul
        'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>', // will generate the clickable breadcrumb links
        'inactiveLinkTemplate' => '<li>{label}</li>', // will generate the current page url : <li>News</li>
        'homeLink' => '<li><a href="' . Yii::app()->homeUrl . '">Главная</a></li>', // will generate your homeurl item : <li><a href="/dr/dr/public_html/">Home</a></li>
        'separator' => ""
    ));
    ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <h1>Форумы
                <small>Прочитай, предложи, обсуди</small>
            </h1>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3">
            <?php $this->renderPartial("../partial/_categories", ["menuItem" => $thread->forum_id]); ?>
        </div>
        <div class="col-md-9">
            <h2><?php echo CHtml::encode($thread->subject); ?>
                <small>
                    создана
                    <?php echo Users::model()->getUsernameWithLink($thread->firstPost->author_id, true); ?>
                </small>
            </h2>
            <?php
            $postsProvider->getData();
            ?>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $this->widget('LinkPager', ['pages' => $postsProvider->pagination, "htmlOptions" => ["class" => 'pagination pagination-sm pull-left']]);
                    echo $reply;
                    if (!Yii::app()->user->isGuest && Yii::app()->user->isForumAdmin()) {
                        echo CHtml::link("Редактировать тему", ["update", "id" => $thread->id], ["class" => "btn btn-default pull-right btn-sm", "style" => "margin-right: 5px;"]);
                    }
                    ?>
                </div>
            </div>
            <?php
            $this->widget('zii.widgets.CListView', array(
                //'htmlOptions'=>array('class'=>'thread-view'),
                'dataProvider' => $postsProvider,
                'template' => '{items}<hr>',
                'itemView' => '_post',
                'htmlOptions' => array(
                    'class' => Yii::app()->controller->module->forumListviewClass,
                ),
            ));
            ?>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $this->widget('LinkPager', ['pages' => $postsProvider->pagination, "htmlOptions" => ["class" => 'pagination pagination-sm pull-left']]);
                    echo $reply;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
