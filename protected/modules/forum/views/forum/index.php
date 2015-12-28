<div class="forum">
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $breadcrumbs,
        "htmlOptions" => ["class" => "breadcrumb"],
        'tagName' => 'ul', // will change the container to ul
        'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>', // will generate the clickable breadcrumb links
        'inactiveLinkTemplate' => '<li>{label}</li>', // will generate the current page url : <li>News</li>
        'homeLink' => '<li><a href="' . Yii::app()->homeUrl . '">Главная</a></li>', // will generate your homeurl item : <li><a href="/dr/dr/public_html/">Home</a></li>
        'separator' => ""
    ));
    ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <h1>Форумы
                <small>Прочитай, предложи, обсуди</small>
            </h1>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3">
            <?php $this->renderPartial("../partial/_categories", ["menuItem" => $menuItem]); ?>
        </div>
        <div class="col-md-9">
            <?php $this->renderPartial("../partial/_topics", ["threadsProvider" => $data, "forum" => $forum]); ?>

        </div>
    </div>
</div>