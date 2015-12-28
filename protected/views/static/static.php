<?php
if (strlen($base_model->css) > 0)
    Yii::app()->clientScript->registerCss('page', $base_model->css);
$bc = $this->renderPartial('application.views.partial.breadcrumbs', null, true);
if ($base_model->isInContent) {
    ?>
    <div class="staticPage">

        <?php echo $bc; ?>
        <h1 class="title"><?php echo $base_model->header; ?></h1>
        <hr/>

        <div style="padding: 0 30px;">
            <?php echo $base_model->data; ?>
            <div class="clear"></div>
        </div>
    </div>
<?php
} else {
    echo '<div class="staticPage">';
    echo str_replace("{breadcrumbs}", $bc, $base_model->data);
    echo '</div>';
}?>