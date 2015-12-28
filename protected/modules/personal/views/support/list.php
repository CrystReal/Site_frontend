<div class="page supportDesc">
    <h1 class="title">Служба поддержки</h1>
    <hr/>

    <div class="row addRow">
        <div class="col-md-12 text-center">
            <a class="btn btn-primary" href="<?php echo $this->createUrl("add"); ?>">Написать запрос</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            /**
             * @var $model SupportTickets[]
             */
            if (count($model) > 0) {
                ?>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Тема</th>
                        <th style="width: 150px">Статус</th>
                        <th style="width: 50px"></th>
                    </tr>
                    <?php foreach ($model as $item) { ?>
                        <tr>
                            <td><?php echo $item->id; ?></td>
                            <td><?php echo CHtml::encode($item->subject); ?></td>
                            <td class="text-center">
                                <?php echo $item->getStatusLabel(); ?>
                            </td>
                            <td><a class="btn btn-default btn-sm"
                                   href="<?php echo $this->createUrl("view", ["id" => $item->id]); ?>">Просмотреть
                                    переписку</a></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php
            } else {
                ?>
                <h3 class="text-center">Нет запросов.</h3>
            <?php
            } ?>
        </div>
    </div>
</div>