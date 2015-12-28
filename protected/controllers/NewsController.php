<?php

/**
 * Created by Alex Bond.
 * Date: 26.01.14
 * Time: 15:05
 */
class NewsController extends MainController
{
    public function actionList()
    {
        $this->breadcrumbs[] = array(
            'title' => "Новости", 'url' => $this->createUrl("list")
        );
        $this->Title = "Новости";

        $model = new News("search");

        if (!empty($_GET['filter']))
            $model->attributes = $_GET['filter'];

        $dataProvider = $model->search();
        $this->render("list", ["dP" => $dataProvider]);
    }
} 