<?php
if (isset($forum)) $links = array_merge(
    $forum->getBreadcrumbs(true),
    array('Новая тема')
);
else $links = array_merge(
    $thread->getBreadcrumbs(true),
    array('Новый ответ')
);
?>

<div class="forum">
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $links,
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
            <?php $this->renderPartial("../partial/_categories", ["menuItem" => $forum->id]); ?>
        </div>
        <div class="col-md-9">
            <h2>Новая тема
                <small>
                    <?php echo $forum->parent->title . ": " . $forum->title; ?>
                    <i class="icon-bookmark"></i>
                </small>
            </h2>
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'post-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                "htmlOptions" => ["class" => "form form-horizontal"]
            )); ?>

            <?php if (isset($forum)): ?>
                <div class="form-group">
                    <div class="col-md-2">
                        <?php echo $form->labelEx($model, 'subject'); ?>
                    </div>
                    <div class="col-md-9">
                        <?php echo $form->textField($model, 'subject', ["class" => "form-control"]); ?>
                        <?php echo $form->error($model, 'subject'); ?>
                    </div>
                </div>
            <?php endif; ?>

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

            <?php if (Yii::app()->user->isForumAdmin()): ?>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-1">
                        <?php echo $form->checkBox($model, 'lockthread', array('uncheckValue' => 0)); ?>
                        <?php echo $form->labelEx($model, 'lockthread'); ?>
                        <?php // echo $form->error($model,'lockthread'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-9">
                        <?php echo CHtml::submitButton('Отправить', ['class' => "btn btn-primary"]); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

