<div class="userProfileUpdate">
    <?php $this->renderPartial('application.views.partial.breadcrumbs'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php ErrInfo::alerts(null); ?>
        </div>
    </div>
    <?php echo CHtml::form(); ?>
    <div class="row">
        <div class="col-md-4">
            <h4>Контактная информация</h4>

            <?php
            $fields = ["firstName", "lastName", "vk_link", "fb_link", "yt_link", "twitter_link"];
            foreach ($fields as $item) {
                ?>
                <div class="form-group">
                    <?php
                    echo CHtml::activeLabel($model, $item);
                    echo CHtml::activeTextField($model, $item, ["class" => "form-control"]);
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="col-md-4">
            <h4>Настройки профиля</h4>

            <div class="form-group">
                <?php
                echo CHtml::activeLabel($model, "email");
                echo CHtml::activeTextField($model, "email", ["class" => "form-control"]);
                ?>
            </div>
            <div class="form-group">
                <label for="newPassword">Пароль</label>
                <input class="form-control" name="Users[newPassword]"
                       id="newPassword" type="password" maxlength="128">
            </div>
            <div class="form-group">
                <label for="newPasswordAgain">Пароль еще раз</label>
                <input class="form-control" name="Users[newPasswordAgain]"
                       id="newPasswordAgain" type="password" maxlength="128">
            </div>
            <div class="form-group">
                <label for="newPasswordAgain">Старый пароль</label>
                <input class="form-control" name="Users[oldPassword]"
                       id="oldPassword" type="password" maxlength="128">
            </div>
        </div>
        <div class="col-md-4">
            <h4>Различная информация</h4>

            <div class="form-group">
                <?php
                echo CHtml::activeLabel($model, "location");
                echo CHtml::activeTextField($model, "location", ["class" => "form-control"]);
                ?>
            </div>
            <div class="form-group">
                <?php
                echo CHtml::activeLabel($model, "sex");
                echo CHtml::activeDropDownList($model, "sex", $model->getSexOptions(), ["class" => "form-control"]);
                ?>
            </div>
            <div class="form-group">
                <?php
                echo CHtml::activeLabel($model, "interests");
                echo CHtml::activeTextField($model, "interests", ["class" => "form-control"]);
                ?>
            </div>
            <div class="form-group">
                <?php
                echo CHtml::activeLabel($model, "birthday");
                ?>
                <div class="input-group date">
                    <input data-date="<?php echo $model->getBirthday() ?>" data-date-format="dd.mm.yyyy"
                           class="form-control datepickerObj" size="16" type="text" name="Users[birthday]"
                           value="<?php echo $model->getBirthday() ?>"
                           readonly>
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr/>
            <div class="form-group">
                <?php
                echo CHtml::activeLabel($model, "about");
                ?>
                <span class="help-block">Разрешено использование HTML.</span>
                <?php
                echo CHtml::activeTextArea($model, "about", ["class" => "form-control", "rows" => "5"]);
                ?>
            </div>
            <div class="form-group">
                <?php
                echo CHtml::activeLabel($model, "signature");
                ?>
                <span class="help-block">Разрешено использование HTML.</span>
                <?php
                echo CHtml::activeTextArea($model, "signature", ["class" => "form-control", "rows" => "5"]);
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-actions text-center">
                <br/>
                <input type="submit" class="btn btn-primary" value="Сохранить"/>
                <br/>
                <br/>
            </div>
        </div>
    </div>
    </form>
</div>