<?php
$this->widget('zii.widgets.CBreadcrumbs', array(
    'links' => array_merge(
        $model->getBreadcrumbs(!$model->isNewRecord),
        array($model->isNewRecord ? 'Новый форум' : 'Редактирование форума')
    )
));
?>
<div class="form" style="margin:20px;">
    <?php $form = $this->beginWidget('CActiveForm', ["htmlOptions" => ["class" => "form-horizontal"]]); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <div class="form-group">
        <div class="col-md-2">
            <?php echo $form->labelEx($model, 'parent_id'); ?>
        </div>
        <div class="col-md-9">
            <?php echo CHtml::activeDropDownList($model, 'parent_id', CHtml::listData(
                Forum::model()->findAllByAttributes(["parent_id" => null]),
                'id', 'title'
            ), ['empty' => 'Никакой (root)', "class" => "form-control"]); ?>
            <?php echo $form->error($model, 'parent_id'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-2">
            <?php echo $form->labelEx($model, 'title'); ?>
        </div>
        <div class="col-md-9">
            <?php echo $form->textField($model, 'title', ["class" => "form-control"]); ?>
            <?php echo $form->error($model, 'title'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-2">
            <?php echo $form->labelEx($model, 'description'); ?>
        </div>
        <div class="col-md-9">
            <?php echo $form->textArea($model, 'description', array('rows' => 10, 'cols' => 70, "class" => "form-control")); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-2">
            <?php echo $form->labelEx($model, 'listorder'); ?>
        </div>
        <div class="col-md-9">
            <?php echo $form->textField($model, 'listorder', ["class" => "form-control"]); ?>
            <?php echo $form->error($model, 'listorder'); ?>
        </div>
    </div>

    <!--<div class="form-group rememberMe">
        <div class="col-md-9 col-md-offset-2">
            <?php echo $form->checkBox($model, 'isCat', array('uncheckValue' => 0)); ?>
            <?php echo $form->labelEx($model, 'isCat'); ?>
            <?php // echo $form->error($model,'lockthread'); ?>
        </div>
    </div>-->
    <div class="form-group rememberMe">
        <div class="col-md-9 col-md-offset-2">
            <?php echo $form->checkBox($model, 'is_locked', array('uncheckValue' => 0)); ?>
            <?php echo $form->labelEx($model, 'is_locked'); ?>
            <?php // echo $form->error($model,'lockthread'); ?>
        </div>
    </div>

    <div class="form-actions buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ["class" => "btn btn-primary"]); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<!-- form -->