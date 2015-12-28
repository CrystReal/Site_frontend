<?php

/**
 * Created by Alex Bond.
 * Date: 24.01.14
 * Time: 19:12
 */
class BowSpleefController extends MainController
{
    public function actionList()
    {
        $model = new BsStatsGames("search");
        $this->Title = "Архив боев BowSpleef";

        if (!empty($_GET['filter']))
            $model->attributes = $_GET['filter'];

        $dataProvider = $model->search();
        $this->render("list", ["dataProvider" => $dataProvider]);
    }

    public function actionView()
    {
        $model = BsStatsGames::model()->findByPk($_GET['id']);
        if (!$model)
            $this->redirect($this->createUrl("list"));

        $this->render("view", ["model" => $model]);
    }
} 