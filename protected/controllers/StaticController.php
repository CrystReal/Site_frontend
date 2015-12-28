<?php

class StaticController extends MainController
{
    function actionStatic()
    {
        if (isset($_GET['id']) && isset($_GET['alias'])) {
            $db = StaticPages::model()->findByPk($_GET['id']);
            if ($db) {
                if ($db->alias != $_GET['alias']) {
                    $this->redirect($this->createUrl("/Static/static", array("id" => $db->id, "alias" => $db->alias)));
                }
                foreach ($db->getParents() as $item) {
                    $_GET['pages'][] = array("id" => $item->id, "title" => $item->header, "url" => $item->alias);
                }
                $_GET['pages'][] = array("id" => $db->id, "title" => $db->header, "url" => $db->alias);
                $_GET['page_id'] = $db;
            } else {
                throw new CHttpException(404);
            }
        }
        $base = $_GET['page_id'];
        if ($base) {
            if ($base->type == 4) {
                Yii::app()->session['menu'] = $_GET['pages'];
                $this->redirect('/models');
            }
            $this->genMeta($base);
            $this->current = $base->id;
            $url = "/";
            foreach ($_GET['pages'] as $item) {
                if ($item["isCat"])
                    $this->breadcrumbs[] = array(
                        'title' => $item['title'], 'isCat' => "true"
                    );
                else
                    $this->breadcrumbs[] = array(
                        'title' => $item['title'], 'url' => $url . $item['id'] . "-" . $item['url']
                    );
            }
            $this->render("static", array('base_model' => $base));
        } else {
            throw new CHttpException(404, Yii::t('app', 'Page not found'));
        }
    }

    function actionIndex()
    {
        $base = StaticPages::model()->find('type=1');
        if ($base) {
            $this->genMeta($base);
            $this->breadcrumbs[] = array(
                'title' => $base->header, 'url' => "/" . $base->alias
            );
            $this->current = 1;
            $this->render("index", array('base_model' => $base));
        } else {
            throw new CHttpException(404, Yii::t('app', 'Page not found'));
        }
    }
}

