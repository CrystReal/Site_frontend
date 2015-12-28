<p style="text-align: center">
    <a href="http://crystreal.net"><img src="<?php echo Yii::app()->params['siteUrl']; ?>/static/images/logo.png"
                                        alt="Crystal Reality"/></a>
</p>
<p>
    Приветствуем тебя, <?php echo $user->username; ?>!
</p>
<p>
    Для активации перейди по <a
        href="<?php echo Yii::app()->params->siteUrl . "/" . $this->createUrl("/personal/auth/activate", ["id" => $user->id, "key" => $user->getActivationKey()]); ?>">этой
        ссылке</a>.
</p>
<p></p>
<p>С уважением,<br/>команда Crystal Reality.</p>