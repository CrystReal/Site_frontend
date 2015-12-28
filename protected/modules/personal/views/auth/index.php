<div class="authPage">
    <div class="row">
        <div class="col-md-12">
            <?php ErrInfo::alerts(null); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Нет логина?</h2>

            <p>Пройди быструю регистрацию и начни незабываемые приключения!</p>

            <p style="padding: 20px 0">
                <a class="btn btn-lg btn-success" href="<?php echo $this->createUrl("registration"); ?>">Регистрация</a>
            </p>
        </div>
        <div class="col-md-6">
            <h2>Вход в личный кабинет</h2>

            <div class="row">
                <div class="col-md-12">&nbsp;
                    <?php
                    /**
                     * @var $model Users
                     */
                    if (count($model->getErrors()) > 0) {
                        foreach ($model->getErrors() as $item) {
                            foreach ($item as $error)
                                echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <?php echo CHtml::form("","post",["class"=>"form-horizontal"]) ?>
                <div class="form-group">
                    <label for="login" class="col-sm-3 col-md-offset-1 control-label">Имя игрока:</label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="login" maxlength="16" name="Auth[username]">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 col-md-offset-1 control-label">Пароль:</label>

                    <div class="col-sm-7">
                        <input type="password" class="form-control" id="password" name="Auth[password]">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-7 col-md-offset-4 text-left">
                        <input type="checkbox" name="Auth[saveAuth]" value="1" id="saveAuth"/>
                        <label for="saveAuth">Запомнить?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 col-md-offset-4" style="text-align: center; padding: 10px 0;">
                        <input type="submit" class="btn btn-success" value="Войти"/>

                        <p style="padding-top: 10px">
                            <a href="<?php echo $this->createUrl("passwordReset"); ?>">Забыл имя или пароль?</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>