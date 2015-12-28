<div class="slideFullWidth mainWellcome"
     style="background: url(/static/uploads/mainSlide.jpg) no-repeat top center; background-size: 100%">
    <h1>Crystal Reality Games</h1>

    <p>Ошеломляющий проект с самыми крутыми<br> и эксклюзивными играми Minecraft в России.</p>
    <a class="btn btn-primary btn-large"
       href="<?php if (Yii::app()->user->isGuest) echo $this->createUrl("personal/auth/index"); else echo $this->createUrl("/Start/index"); ?>">Начни
        играть »</a>
</div>
<div class="row main underSlide">
    <div class="col-md-4">
        <h3>Последние новости</h3>

        <?php if ($this->beginCache("mainNews", array('duration' => 3600))) { ?>
            <?php
            $news = News::model()->last2()->findAll();
            foreach ($news as $item) {
                ?>
                <a href="<?php echo $item->getUrl(); ?>" class="newsItem">
                    <img src="<?php echo $item->getImage("100x70"); ?>"/>
                    <h4 class="title"><?php echo $item->header; ?></h4>

                    <p class="info"><?php echo $item->short_data; ?></p>
                </a>
            <?php
            }
            ?>
            <?php $this->endCache();
        } ?>
        <p class="text-center"><a href="/news">Все новости</a></p>
    </div>
    <div class="col-md-4" style="padding-top: 40px">
        <a href="https://flyspring.ru/" target="_blank"><img src="/static/images/flyspring.png"/></a>

    </div>
    <div class="col-md-4">
        <h3>Последние бои</h3>

        <?php
        //7
        $lastGames = AllGames::getLastGames(7);
        foreach ($lastGames as $item) {
            ?>
            <div class="lastGames">
                <div class="item">
                    <?php echo $item['winner']; ?> бой <a
                        href="<?php echo $item['gameLink']; ?>"><strong><?php echo $item['gameId']; ?></strong></a> в <a
                        href="<?php echo $item['typeLink']; ?>"><strong><?php echo $item['typeName']; ?></strong></a>
                </div>
            </div>
        <?php
        }
        ?>

        <?php
        //TODO
        ?>
    </div>
</div>