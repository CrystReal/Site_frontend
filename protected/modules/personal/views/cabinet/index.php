<?php
/**
 * @var $user Users
 */
$user = Yii::app()->user->model;
?>
<div class="cabinet">
    <?php $this->renderPartial('application.views.partial.breadcrumbs'); ?>
    <div class="row">
        <div class="col-md-12">
            <h2 style="text-align: center; margin-top: 0"><?php echo Yii::app()->user->model->username; ?></h2>

            <p class="statuses">
                <?php echo Yii::app()->user->model->getBadges(); ?>
            </p>
            <?php ErrInfo::alerts(null); ?>
        </div>
    </div>
    <div class="row balances">
        <div class="col-md-offset-4 col-md-2">
            <img src="/static/images/icons/currency_sign_dollar_30.png" alt="Реальные деньги"
                 title="Реальные деньги"/> <?php echo Yii::app()->user->model->getMoney(); ?>
        </div>
        <div class="col-md-2">
            <img src="/static/images/icons/batch_process_30.png" alt="Виртуальные деньги (опыт)"
                 title="Виртуальные деньги (опыт)"/> <?php echo Yii::app()->user->model->getExp(); ?>
        </div>
    </div>
    <div class="row balancesAds">
        <div class="col-md-offset-4 col-md-2 text-center">
            <a href="#" class="btn btn-sm btn-warning" onclick='alertify.alert("Пока не готово."); return false;'>Пополнить</a>
        </div>
        <div class="col-md-2 text-center">
            <a href="#" class="btn btn-sm btn-warning" onclick='alertify.alert("Пока не готово."); return false;'>Ускорить
                получение</a>
        </div>
    </div>
    <div class="row profileInfo">
        <div class="col-md-12">
            <p>
                Ты всегда можешь показать друзьям свой профиль предоставив им данную ссылку:
            </p>

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <input type="text" onClick="this.select();"
                           value="<?php echo $user->getProfileLink(); ?>"
                           class="form-control blockEdit"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row actionsRow">
        <div class="col-md-4 alerts">
            <h4><a href="<?php echo $this->createUrl("notifications"); ?>" onclick="return false;" style="color: #000"
                   rel="tooltip" title="Просмотреть историю">Уведомления</a></h4>

            <!--<div class="alert alert-info">
                <div class="pull-right">
                    <a href="#" style="color: darkgreen" rel="tooltip" title="Добавить"><i class="fa fa-check"></i></a>
                    <a href="#" style="color: darkred" rel="tooltip" title="Отказать"><i class="fa fa-times"></i></a>
                </div>
                <a href="#"><strong>Artpechka</strong></a> предожил тебе дружбу.
            </div>
            <div class="alert alert-danger"><strong>DefKill</strong> был обновлен до версии 1.2-АЛЬФА.</div>
            <div class="alert alert-success"><strong>Добро жаловать на Crystal Reality Games!</strong></div>
            <div class="alert alert-success"><strong>Добро жаловать на Crystal Reality Games!</strong></div>-->
            <div class="alert alert-success"><strong>Добро жаловать на Crystal Reality Games!</strong></div>
        </div>
        <div class="col-md-4 vips">
            <h4 class="bold">VIP статус</h4>

            <p class="text-center no-margin">Не доступен.</p>
            <!--<p class="text-center no-margin">У тебя сейчас</p>

            <p class="text-center no-margin status" style="color: #c5a100">VIP+</p>

            <p class="text-center">статус.</p>

            <p class="text-center">Закончится через</p>

            <p class="text-center" rel="tooltip" title="20 января 2014"><strong>10 дней</strong></p>-->
        </div>
        <div class="col-md-4 text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h4>Действия</h4>

                    <p>
                        <a href="<?php echo $this->createUrl("edit"); ?>" class="btn btn-info btn-block">Редактировать
                            профиль</a>
                    </p>

                    <p>
                        <a href="<?php echo $this->createUrl("friends/friends");?>" class="btn btn-success btn-block">Мои друзья</a>
                    </p>

                    <p>
                        <a href="<?php echo $this->createUrl("/personal/support/list"); ?>"
                           class="btn btn-default btn-block">Тех. поддержка</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>