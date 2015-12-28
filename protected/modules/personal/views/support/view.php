<?php
/**
 * @var $model SupportTickets
 * @var $comment SupportTicketsComments
 */
?>
<div class="page supportDesc">
    <h1 class="title">Служба поддержки</h1>
    <hr/>

    <div class="row">
        <div class="col-md-12">
            <h2>Запрос #<?php echo $model->id; ?></h2>

            <table class=" table table-bordered table-striped">
                <?php
                foreach ($model->comments as $comment) {
                    ?>
                    <tr <?php if($comment->isAnswer) echo "class='success'" ?>>
                        <td style="width: 150px;">
                            <?php
                            echo Users::model()->getUsernameAvatarWithLink($comment->user->id, "150");
                            ?>
                            <p class="text-center">
                                <?php
                                echo Users::model()->getUsernameWithLink($comment->user->id);
                                ?>
                            </p>

                            <p class="text-center">
                                <?php
                                echo $comment->user->getBadges();
                                ?>
                            </p>

                            <p class="text-center">
                                <?php
                                echo date("j.n.Y G:i", $comment->datePosted);
                                ?>
                            </p>
                        </td>
                        <td>
                            <p>
                                <?php
                                if ($comment->isAnswer) {
                                    echo $comment->content;
                                } else {
                                    echo nl2br(CHtml::encode($comment->content));
                                }
                                ?>
                            </p>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo $this->createUrl("comment", ["id" => $model->id]); ?>" method="post">
                <div class="form-group">
                    <label for="status">Закрываем запрос?</label>
                    <select class="form-control" name="toClose" id="status">
                        <option value="0">Не закрывать</option>
                        <option value="1">Закрыть</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="text">Коментарий</label>
                    <textarea class="form-control" rows="5" name="content" id="text"></textarea>
                </div>
                <div class="form-actions text-center">
                    <br>
                    <input type="submit" class="btn btn-primary" value="Создать запрос">
                    <br>
                    <br>
                </div>
            </form>
        </div>
    </div>
</div>