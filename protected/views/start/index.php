<div class="startPage">

    <?php $this->renderPartial('application.views.partial.breadcrumbs'); ?>
    <h1 class="title">Начни играть
        <small>Все сервера работают 24/7</small>
    </h1>
    <div class="row">
        <div class="col-md-4">
            <h3>Информация</h3>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td style="width: 160px;">
                        <b>Подключаемся к:</b>
                    </td>
                    <td>
                        <ul style="list-style: none; padding: 0">
                            <li class="lead">mc.crystreal.net</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Версии</b>
                    </td>
                    <td>
                        <ul></ul>
                        <li>1.7.2</li>
                        <li>1.7.4</li>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Статус</b>
                    </td>
                    <td>
                        <?php
                        $key = Yii::app()->redis->get("lobby_online");
                        if ($key && $key >= time() - 60) {
                            echo "<span style='color: green'><i class='fa fa-circle'></i></span> Все работает.";
                        } else {
                            echo "<span style='color: red'><i class='fa fa-times'></i></span> Сервер недоступен.";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Последнее обновление</b>
                    </td>
                    <td>
                        менее минуты назад
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Клиент</b>
                    </td>
                    <td>
                        <a href="https://minecraft.net/download" target="_blank" class="btn btn-success btn-sm btn-block">Лицензионный</a><br/>
                        <a href="/static/launcher.exe" target="_blank" class="btn btn-success btn-sm btn-block">Пиратский</a>
                    </td>
                </tr>
                </tbody>
            </table>
            <h3>Администрация онлайн
                <small><?php echo count($admins) ?></small>
            </h3>
            <?php
            if (count($admins) == 0)
                echo "Анархия - мать порядка!";
            foreach ($admins as $key => $item) {
                echo Users::model()->getUsernameAvatarWithLink($key, 40);
            } ?>
        </div>
        <div class="col-md-8">
            <h3>Игроки онлайн
                <small><?php echo count($users); ?>/1000</small>
            </h3>
            <hr/>
            <?php
            $i = 1;
            foreach ($users as $key => $item) {
                if ($i == 120)
                    break;
                $i++;
                echo Users::model()->getUsernameAvatarWithLink($key, 40);
            }
            if (count($users) > 119)
                echo '<p class="text-center"><span class="label label-info">и еще ' . (count($users) - 119) . '</span></p>';
            ?>
        </div>
    </div>
</div>