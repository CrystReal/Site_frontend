<div class="authPage">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>Регистрация</h2>

            <p style="text-align: center; padding: 10px 0;">
                Ты на верном пути! Заполни поля ниже для начала регистрации.
            </p>
            <?php ErrInfo::alerts($model); ?>
            <?php echo CHtml::form("", "post", ["class" => "form-horizontal", "id" => "registerForm"]) ?>

            <div class="form-group">
                <label for="username" class="col-sm-3 col-md-offset-1 control-label">Имя игрока:</label>

                <div class="col-sm-5">
                    <div class="input-group">
                        <input type="text" class="form-control" id="username" name="Reg[username]">
                            <span class="input-group-addon"><a href="#"
                                                               onclick="checkUserName($('#username').val()); return false;">Проверить</a></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-3 col-md-offset-1 control-label">Пароль:</label>

                <div class="col-sm-5">
                    <input type="password" class="form-control" id="password" name="Reg[password]">
                </div>
            </div>
            <div class="form-group">
                <label for="password2" class="col-sm-3 col-md-offset-1 control-label">Пароль еще раз:</label>

                <div class="col-sm-5">
                    <input type="password" class="form-control" id="password2" name="Reg[password2]">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-3 col-md-offset-1 control-label">Email:</label>

                <div class="col-sm-5">
                    <input type="email" class="form-control" id="email" name="Reg[email]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center; padding: 10px 0;">
                    <input type="submit" class="btn btn-success" value="Зарегистрироваться"/>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#registerForm").submit(function (e) {
        if ($('#username').val().length > 0 && $('#password').val().length > 0 && $('#password2').val().length > 0 && $('#email').val().length > 0) {
            if ($('#password').val() == $('#password2').val()) {
                if ($('#username').val().length >= 3 && $('#username').val().length <= 16 && usernameChars($('#username').val())) {
                    if (isUserExists($('#username').val())) {
                        e.preventDefault();
                        alertify.alert("Даное имя уже существует.");
                    }
                } else {
                    e.preventDefault();
                    alertify.alert("Имя пользователя может быть от 3х до 16 символов.<br>Разрешено использование латинских бакв, цифр и знаков - и _");
                }
            } else {
                e.preventDefault();
                alertify.alert("Пароли не совпадают");
            }
        } else {
            e.preventDefault();
            alertify.alert("Заполни все поля.");

        }
    });

    function usernameChars(user) {
        var re = new RegExp(/^[0-9a-zA-Z-_]+$/);
        if (user.match(re))
            return true;
        else
            return false;
    }

    function isUserExists(user) {
        var out = true;
        $.ajax({
            url: '<?php echo $this->createUrl("CheckUserNameAJAX"); ?>?username=' + user,
            success: function (data) {
                if (data.exists)
                    out = true;
                else
                    out = false;
            },
            error: function (text) {
                out = true;
            },
            dataType: 'json',
            async: false
        });
        return out;
    }

    function checkUserName(user) {
        var obj = $("#username").parent();
        if (obj.hasClass("has-error") || obj.hasClass("has-success")) {
            obj.removeClass("has-error");
            obj.removeClass("has-success");
        }
        if (user.length >= 3 && user.length <= 16 && usernameChars(user)) {
            if (isUserExists($('#username').val())) {
                alertify.alert("Даное имя уже существует.");
            } else {
                obj.addClass("has-success");
            }
        } else {
            alertify.alert("Имя пользователя может быть от 3х до 16 символов.<br>Разрешено использование латинских бакв, цифр и знаков - и _");
        }
    }
</script>