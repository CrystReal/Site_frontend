<?php

/**
 * Created by Alex Bond.
 * Date: 24.01.14
 * Time: 19:12
 */
class TntRunController extends MainController
{
    public function actionList()
    {
        $model = new TntrunStatsGames("search");
        $this->Title = "Архив боев TNT Run";

        if (!empty($_GET['filter']))
            $model->attributes = $_GET['filter'];

        $dataProvider = $model->search();
        $this->render("list", ["dataProvider" => $dataProvider]);
    }

    public function actionView()
    {
        $model = TntrunStatsGames::model()->findByPk($_GET['id']);
        if (!$model)
            $this->redirect($this->createUrl("list"));

        $this->render("view", ["model" => $model]);
    }
} 