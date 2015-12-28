<!--DEVELOPED IN UPDG-->
<!DOCTYPE html>

<html lang="en-US">

<head>
    <title><?php echo Yii::app()->getController()->Title; ?> :: Crystal Reality Games</title>
    <?php
    $metas = Yii::app()->getController()->meta;
    if (isset($metas['desc']) && strlen($metas['desc']) > 0) {
        echo '<meta name="description" content="' . $metas['desc'] . '" />';
    } else {
        echo '<meta name="description" content="' . Yii::app()->getController()->settings['defaultMetaDescription'] . '" />';
    }
    if (isset($metas['keywords']) && strlen($metas['keywords']) > 0) {
        echo '<meta name="keywords" content="' . $metas['keywords'] . '" />';
    } else {
        echo '<meta name="keywords" content="' . Yii::app()->getController()->settings['defaultMetaKeywords'] . '" />';
    }
    if (isset($metas['author']) && strlen($metas['author']) > 0) {
        echo '<meta name="author" content="' . $metas['author'] . '" />';
    }
    ?>
    <meta charset='UTF-8'/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='/static/css/style.css' type='text/css' media='all'/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset=latin,cyrillic' rel='stylesheet'
          type='text/css'>

    <script type='text/javascript' src='//code.jquery.com/jquery-1.10.1.min.js'></script>

</head>

<body>
<div class="container">
    <div class="preHeader">
        <div class="left"><span class="serverAddress">mc.crystreal.net</span></div>
        <div class="right">
            <?php if (Yii::app()->user->isGuest) { ?>
                <a class="btn btn-success"
                   href="<?php echo $this->createUrl("/personal/auth/registration") ?>">Регистрация</a> <a
                    class="btn btn-success" href="<?php echo $this->createUrl("/personal/auth/index") ?>"
                    id="authButtonHeader" onclick="return false;">Вход</a>

                <div id="loginPopover" class="hide">
                    <?php echo CHtml::form($this->createUrl("/personal/auth/index"), "post") ?>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Auth[username]" placeholder="Имя игрока"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="Auth[password]" placeholder="Пароль"/>
                        </div>
                        <div class="form-group text-center">
                            <input type="checkbox" name="Auth[saveAuth]" value="1" id="saveAuth"/>
                            <label for="saveAuth">Запомнить?</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Войти</button>
                    </form>
                </div>
            <?php } else { ?>
                <div class="userInfo">
                    <a href="<?php echo $this->createUrl("/personal/cabinet/index") ?>" title="Личный кабинет"
                       data-original-title="Личный кабинет" data-toggle="tooltip" data-placement="bottom">
                        <?php echo Yii::app()->user->model->getAvatar(Yii::app()->user->model->username, 30); ?>
                        <span><?php echo Yii::app()->user->model->username; ?></span>
                    </a>
                    <a class="btn btn-danger btn-sm"
                       href="<?php echo $this->createUrl("/personal/auth/logout") ?>">Выход</a>
                </div>
            <?php } ?>
        </div>
    </div>
    <header>
        <nav class="leftNav">
            <ul>
                <li><a href="#" onclick="return false;">Наши игры</a>
                    <ul>
                        <li><a href="/games/defkill">DefKill</a></li>
                        <li><a href="/games/quakecraft">QuakeCraft</a></li>
                        <li><a href="/games/bowspleef">Bow Spleef</a></li>
                        <li><a href="/games/tntrun">TNT Run</a></li>
                    </ul>
                </li>
                <li><a href="#" onclick="return false;">Статистика</a>
                    <ul>
                        <li><a href="/stats/defKill/list">DefKill</a></li>
                        <li><a href="/stats/quakeCraft/list">QuakeCraft</a></li>
                        <li><a href="/stats/bowSpleef/list">Bow Spleef</a></li>
                        <li><a href="/stats/tntRun/list">TNT Run</a></li>
                    </ul>
                </li>
                <li><a href="/u/">Игроки</a></li>
            </ul>
        </nav>
        <h1 class="logo"><a href="/"><img src="/static/images/logo.png"/></a></h1>
        <nav class="rightNav">
            <ul>
                <li><a href="/news">Новости</a></li>
                <li><a href="/forum">Форум</a></li>
                <li><a href="/rules" style="color: #00c600">Правила</a></li>
            </ul>
        </nav>
        <div class="clear"></div>
    </header>
    <div class="page">
        <?php echo $content; ?>
    </div>
    <footer>
        <div class="copyright">© 2012-<?php echo date("Y"); ?> Crystal Reality Network</div>
        <ul class="footerMenu">
            <li><a href="/team">Команда</a></li>
            <li><a href="/contacts">Контакты</a></li>
        </ul>
        <div class="clear"></div>
    </footer>
</div>
<script type='text/javascript' src='/static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='/static/js/bootstrap-datepicker.min.js'></script>
<script type='text/javascript' src='/static/js/alertify.min.js'></script>
<script type='text/javascript' src='/static/js/plugins/fontcolor/fontcolor.js'></script>
<script type='text/javascript' src='/static/js/plugins/fontsize/fontsize.js'></script>
<script type='text/javascript' src='/static/js/plugins/fontfamily/fontfamily.js'></script>
<script type='text/javascript' src='/static/js/plugins/textdirection/textdirection.js'></script>
<script type='text/javascript' src='/static/js/redactor.min.js'></script>
<script type='text/javascript' src='/static/js/redactorLangs/ru.js'></script>
<script type='text/javascript' src='/static/js/hogan-2.0.0.min.js'></script>
<script type='text/javascript' src='/static/js/typeahead.min.js'></script>
<script type='text/javascript' src='/static/js/scripts.js'></script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-8993829-21', 'crystreal.net');
    ga('send', 'pageview');

</script>
</body>

</html>