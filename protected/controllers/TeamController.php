<?php

/**
 * Created by Alex Bond.
 * Date: 26.01.14
 * Time: 15:05
 */
class TeamController extends MainController
{
    public function actionList()
    {
        $this->breadcrumbs[] = array(
            'title' => "Команда", 'url' => "/team"
        );
        $this->render("list");
    }
} 