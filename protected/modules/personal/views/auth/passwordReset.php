<div class="authPage">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>Напоминание имени и пароля</h2>

            <p style="text-align: center; padding: 10px 0;">
                Введи в поле ниже email на который был зарегистрирован твой профиль и мы вышлем тебе информацию для
                восстановления пароля.
            </p>
            <?php ErrInfo::alerts(null); ?>
            <?php echo CHtml::form("", "post", ["class" => "form-horizontal"]) ?>
            <div class="form-group">
                <label for="email" class="col-sm-3 col-md-offset-1 control-label">Email:</label>

                <div class="col-sm-5">
                    <input type="email" class="form-control" id="email" name="passReset">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center; padding: 10px 0;">
                    <input type="submit" class="btn btn-success" value="Напоминить"/>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>