<div class="page supportDesc">
    <h1 class="title">Служба поддержки</h1>
    <hr/>

    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo $this->createUrl("add"); ?>" method="post">
                <div class="form-group">
                    <label for="subject">Тема</label>
                    <input class="form-control" name="subject"
                           id="subject" type="text" maxlength="1000"
                           value="">
                </div>
                <div class="form-group">
                    <label for="text">Опишите проблему</label>
                    <textarea class="form-control" rows="5" name="text" id="text"></textarea>
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