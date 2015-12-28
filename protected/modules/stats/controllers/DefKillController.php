<?php

/**
 * Created by Alex Bond.
 * Date: 18.01.14
 * Time: 18:05
 */
class DefKillController extends MainController
{
    public function actionList()
    {
        $model = new DkStatsGames("search");
        $this->Title = "Архив боев DefKill";
        if (!empty($_GET['filter']))
            $model->attributes = $_GET['filter'];

        $dataProvider = $model->search();
        $this->render("list", ["dataProvider" => $dataProvider]);
    }

    public function actionView()
    {
        $model = DkStatsGames::model()->findByPk($_GET['id']);
        if (!$model)
            $this->redirect($this->createUrl("list"));

        $this->render("view", ["model" => $model]);
    }
} 