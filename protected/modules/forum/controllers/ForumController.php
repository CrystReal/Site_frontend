<?php

class ForumController extends ForumBaseController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array('accessControl');
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            // ALL users
            array('allow',
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            /*
                        // authenticated users
                        array('allow',
                            'actions' => array(),
                            'users' => array('@'),
                        ),
            */

            // administrators
            array('allow',
                'actions' => array('create', 'update', 'delete'),
                'users' => array('@'), // Must be authenticated
                'expression' => 'Yii::app()->user->isForumAdmin()', // And must be admin
            ),

            // deny all users
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * This is basically the "homepage" for the forums
     * It'll show a list of root categories which forums in each
     */
    public function actionIndex()
    {
        if (!isset($_GET['id'])) {
            $forum = null;
            if (!Yii::app()->user->isForumAdmin())
                $criteria = array(
                    'order' => 'lastPost_time DESC',
                    //"with" => ["lastPost", "firstPost"],
                    'condition' => "is_hidden=0",
                    'distinct'=>true,
                    "group" => 't.id'
                );
            else
                $criteria = array(
                    'order' => 'lastPost_time DESC',
                    //"with" => ["lastPost", "firstPost"],
                    "group" => 't.id'
                );

            $data = new CActiveDataProvider('Thread', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->controller->module->threadsPerPage,
                ),
            ));
            $menuItem = 0;
            $breadcrumbs = array('Форум');
        } else {
            $forum = Forum::model()->findByPk($_GET['id']);
            if (null == $forum)
                throw new CHttpException(404, 'The requested page does not exist.');

            if ($forum->isCat)
                $this->redirect($this->createUrl("index"));

            if (!Yii::app()->user->isForumAdmin())
                $hidden = " AND is_hidden=0";
            else
                $hidden = "";

            $data = new CActiveDataProvider('Thread', array(
                'criteria' => array(
                    'condition' => 'forum_id=' . $forum->id . $hidden,
                ),
                'pagination' => array(
                    'pageSize' => Yii::app()->controller->module->threadsPerPage,
                ),
            ));
            $menuItem = $forum->id;
            $breadcrumbs = $forum->getBreadcrumbs();
        }
        $this->render('index', array(
            'forums' => Thread::model()->findAll(),
            "data" => $data,
            "menuItem" => $menuItem,
            "breadcrumbs" => $breadcrumbs,
            'forum' => $forum
        ));
    }

    /**
     * create action
     */
    public function actionCreate($parentid = null)
    {
        $forum = new Forum;
        $forum->parent_id = $parentid; // Set default

        if (isset($_POST['Forum'])) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] != Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $forum->attributes = $_POST['Forum'];
            if ($forum->validate()) {
                if ((int)$forum->parent_id < 1) $forum->parent_id = null;
                $forum->save();
                $this->redirect($this->createUrl("index"));
            }
        }
        $this->render('editforum', array('model' => $forum));
    }

    /**
     * Update action
     * @param type $id Id of forum to edit.
     * @throws CHttpException if forum not found
     */
    public function actionUpdate($id)
    {
        $forum = Forum::model()->findByPk($id);
        if (null == $forum)
            throw new CHttpException(404, 'The requested page does not exist.');

        if (isset($_POST['Forum'])) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] != Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $forum->attributes = $_POST['Forum'];
            if ($forum->validate()) {
                if ((int)$forum->parent_id < 1) $forum->parent_id = null;
                $forum->save();
                $this->redirect($forum->url);
            }
        }
        $this->render('editforum', array('model' => $forum));
    }

    /**
     * deleteForum action
     * Deletes both categories or forums.
     * Will take all subforums, threads and posts inside with it!
     */
    public function actionDelete($id)
    {
        if (!Yii::app()->request->isPostRequest || !Yii::app()->request->isAjaxRequest)
            throw new CHttpException(400, 'Invalid request');

        // First, we make sure it even exists
        $forum = Forum::model()->findByPk($id);
        if (null == $forum)
            throw new CHttpException(404, 'The requested page does not exist.');

        $forum->delete();
    }

}