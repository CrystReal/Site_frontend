<div class="forum">
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => array_merge(
            $model->getBreadcrumbs(true),
            array('Редактирование')
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
            <?php $this->renderPartial("../partial/_categories", ["menuItem" => $model->forum->id]); ?>
        </div>
        <div class="col-md-9">
            <h2><?php echo CHtml::encode($model->subject); ?>
                <small>
                    создана
                    <?php echo Users::model()->getUsernameWithLink($model->firstPost->author_id, true); ?>
                    <i class="icon-bookmark"></i>
                </small>
                <a class="btn btn-danger btn-sm pull-right" href="<?php echo $model->getUrl(); ?>">Отменить</a>
            </h2>
            <hr/>
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'post-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                "htmlOptions" => ["class" => "form form-horizontal"]
            )); ?>

            <div class="form-group">
                <div class="col-md-2">
                    <?php echo $form->labelEx($model, 'forum_id'); ?>
                </div>
                <div class="col-md-9">
                    <?php echo CHtml::activeDropDownList($model, 'forum_id',
                        Forum::model()->getArrayForDropDownInThreads(), ["class" => "form-control"]); ?>
                    <?php echo $form->error($model, 'forum_id'); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2">
                    <?php echo $form->labelEx($model, 'subject'); ?>
                </div>
                <div class="col-md-9">
                    <?php echo $form->textField($model, 'subject', ["class" => "form-control"]); ?>
                    <?php echo $form->error($model, 'subject'); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-9 col-md-offset-1">
                    <?php echo $form->checkBox($model, 'is_locked', array('uncheckValue' => 0)); ?>
                    <?php echo $form->labelEx($model, 'is_locked'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-1">
                    <?php echo $form->checkBox($model, 'is_sticky', array('uncheckValue' => 0)); ?>
                    <?php echo $form->labelEx($model, 'is_sticky'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-1">
                    <?php echo $form->checkBox($model, 'is_hidden', array('uncheckValue' => 0)); ?>
                    <?php echo $form->labelEx($model, 'is_hidden'); ?>
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


