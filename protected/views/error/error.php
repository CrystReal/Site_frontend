<?php if ($error['code'] == '404') { ?>

    <div id="content">
        <div id="content-layout">
            <div id="content-holder" class="sidebar-position-none">
                <div id="content-box">
                    <div>
                        <div id="page-404">

                            <div id="content-404" class="notice">

                                <h1>404</h1>

                                <p>
                                    Упс. Страничка не найдена </p>

                            </div>
                            <div class="clear"><!-- --></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div id="content">
        <div id="content-layout">
            <div id="content-holder" class="sidebar-position-none">
                <div id="content-box">
                    <div>
                        <div id="page-404">

                            <div id="content-404" class="notice">

                                <h1><?php echo $error['code']; ?></h1>

                                <p>
                                    Упс. Система вернула ошибку №<?php echo $error['code']; ?>. <br/>
                                    Свяжитесь с администрацией.</p>

                            </div>
                            <div class="clear"><!-- --></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>