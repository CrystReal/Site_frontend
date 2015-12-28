<?php
// For admins, add link to delete post
$isAdmin = !Yii::app()->user->isGuest && Yii::app()->user->isForumAdmin();
/**
 * @var $data Post
 */
?>
<hr/>
<div class="row" id="<?php echo $data->id; ?>">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left" style="position:relative;width:540px;">
                    <a class="pull-left" style="position:relative; margin: 4px 5px 0 0;">
                        <?php echo Users::model()->getAvatar($data->author->username, "32"); ?>
                    </a>
                    <?php echo Users::model()->getUsernameWithLink($data->author_id, true); ?>
                    <?php echo $data->author->getBadges(); ?>
                    <div>
                        <a data-container="body" data-placement="right"
                           rel="tooltip" title=""
                           data-original-title="<?php echo Yii::app()->controller->module->format_date($data->created, 'long'); ?>">
                            <small>
                                написал <?php echo AlexBond::time_since(time() - $data->created); ?> назад.
                            </small>
                        </a>
                    </div>
                </div>
                <?php

                ?>
                <?php
                if ($isAdmin) {
                    $deleteConfirm = "Ты уверен? Сообщение будет удалено навсегда!";
                    echo CHtml::ajaxLink('Удалить',
                            array('/forum/post/delete', 'id' => $data->id),
                            array('type' => 'POST', 'success' => 'function(){document.location.reload(true);}'),
                            array('confirm' => $deleteConfirm, 'id' => 'post' . $data->id, "class" => "btn btn-danger btn-sm pull-right", "style" => "margin-left: 5px")
                        ) . " ";
                }
                if ($isAdmin || Yii::app()->user->id == $data->author_id) {
                    ?>
                    <?php echo CHtml::link("Редактировать", array('/forum/post/update', 'id' => $data->id), ["class" => "btn btn-info btn-sm pull-right", "style" => "margin-left: 5px"]); ?>
                <?php
                }
                ?>
                <!--<a class="btn btn-default btn-sm pull-right"
                   href="/forums/topics/52e5711512ca957a1f001e77/posts/new?reply_to_id=52e5711512ca957a1f001e76">Цитировать</a>-->

            </div>
        </div>
        <br>

        <div class="row forum-post">
            <div class="col-md-12">
                <?php
                echo $data->content;
                if ($data->author->signature) {
                    echo '<br />---<br />';
                    echo $data->author->signature;
                }
                ?>
            </div>
        </div>
    </div>
</div>