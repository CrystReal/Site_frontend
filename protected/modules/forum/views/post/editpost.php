<div class="forum">
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => array_merge(
            $model->thread->getBreadcrumbs(true),
            array('Редактировать сообщение')
        ),
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
                    <i class="icon-bookmark"></i>
                </small>
                <a class="btn btn-danger btn-sm pull-right" href="<?php echo $thread->getUrl(); ?>">Отменить</a>
            </h2>
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'post-form',
                "htmlOptions" => ["class" => "form form-horizontal"]
            )); ?>

            <div class="form-group">
                <div class="col-md-12">
                    <?php $this->widget('ext.redactor.ERedactorWidget', array(
                        'model' => $model,
                        'attribute' => 'content',
                        "options" => [
                            'lang' => 'ru',
                            'buttons' => array(
                                'bold', 'italic', 'deleted', '|',
                                'alignment', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
                                'image', 'video', 'link'
                            ),
                            'minHeight' => 200,
                            'plugins' => ["fontcolor", 'fontsize', 'fontfamily']
                        ]
                    )); ?>
                    <?php echo $form->error($model, 'content'); ?>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-9">
                        <?php echo CHtml::submitButton('Сохранить', ['class' => "btn btn-primary"]); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>


