<?php

/**
 * Created by Alex Bond.
 * Date: 24.01.14
 * Time: 19:12
 */
class QuakeCraftController extends MainController
{
    public function actionList()
    {
        $model = new QcStatsGames("search");
        $this->Title = "Архив боев QuakeCraft";

        if (!empty($_GET['filter']))
            $model->attributes = $_GET['filter'];

        $dataProvider = $model->search();
        $this->render("list", ["dataProvider" => $dataProvider]);
    }

    public function actionView()
    {
        $model = QcStatsGames::model()->findByPk($_GET['id']);
        if (!$model)
            $this->redirect($this->createUrl("list"));

        $this->render("view", ["model" => $model]);
    }
} 