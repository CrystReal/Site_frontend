<div class="staticPage">

    <?php $this->renderPartial('application.views.partial.breadcrumbs'); ?>
    <h1 class="title">Новости</h1>
    <hr/>

    <div style="padding: 0 30px;">
        <?php
        $news = $dP->getData();
        foreach ($news as $item) {
            ?>
            <div class="row">
                <div class="col-md-3">
                    <img src="<?php echo $item->getImage("180x180"); ?>"/>
                </div>
                <div class="col-md-9">
                    <h4 class="title" style="margin-top: 0"><?php echo $item->header; ?></h4>

                    <p class="info"><?php echo $item->short_data; ?></p>
                    <a href="<?php echo $item->getUrl(); ?>" class="btn btn-primary pill-right">Перейти к новости</a>
                </div>
            </div>
            <hr/>
        <?php
        }
        $this->widget('LinkPager', array('pages' => $dP->getPagination(), 'header' => "", 'cssFile' => false));
        ?>
        <div class="clear"></div>
    </div>
</div>