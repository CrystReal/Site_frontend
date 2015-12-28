<?php

class ThreadController extends ForumBaseController
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
                'actions' => array('view'),
                'users' => array('*'),
            ),
            // authenticated users
            array('allow',
                'actions' => array('create', 'newreply', "re"),
                'users' => array('@'),
            ),

            // administrators
            array('allow',
                'actions' => array('update', 'delete'),
                'users' => array('@'), // Must be authenticated
                'expression' => 'Yii::app()->user->isForumAdmin()', // And must be admin
            ),

            // deny all users
            array('deny', 'users' => array('*')),
        );
    }

    public function actionView($id)
    {
        $thread = Thread::model()->findByPk($id);
        if (null == $thread)
            throw new CHttpException(404, 'The requested page does not exist.');

        $thread->view_count++;
        $thread->save(false);

        $postsProvider = new CActiveDataProvider('Post', array(
            'criteria' => array(
                'condition' => 'thread_id=' . $id,
                'order' => 'created',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->controller->module->postsPerPage,
            ),
        ));

        $this->render('view', array(
            'thread' => $thread,
            'postsProvider' => $postsProvider,
        ));
    }

    public function actionCreate($id)
    {
        $forum = Forum::model()->findByPk($id);
        if (null == $forum)
            throw new CHttpException(404, 'Forum not found.');
        if ($forum->is_locked && (Yii::app()->user->isGuest || !Yii::app()->user->isForumAdmin()))
            throw new CHttpException(403, 'Forum is locked.');

        $model = new PostForm;
        $model->setScenario('create'); // This makes subject required
        if (isset($_POST['PostForm'])) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] != Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $model->attributes = $_POST['PostForm'];
            if ($model->validate()) {
                $thread = new Thread;
                $thread->forum_id = $forum->id;
                $thread->subject = $model->subject;
                $thread->author_id = Yii::app()->user->id;
                $thread->lastPost_user_id = Yii::app()->user->id;
                $thread->lastPost_time = time();
                $thread->save(false);

                $post = new Post();
                $post->author_id = Yii::app()->user->id;
                $post->thread_id = $thread->id;
                $post->content = $model->content;
                $post->save(false);


                $this->redirect($thread->url);
            }
        }
        $this->render('newThread', array(
            'forum' => $forum,
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $thread = Thread::model()->findByPk($id);
        if (null == $thread)
            throw new CHttpException(404, 'Thread not found.');

        if (isset($_POST['Thread'])) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] != Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $thread->attributes = $_POST['Thread'];
            $thread->author_id = Yii::app()->user->id;
            if ($thread->validate()) {
                $thread->save(false);
                $this->redirect($thread->url);
            }
        }
        $this->render('editthread', array(
            'model' => $thread,
        ));
    }

    /**
     * This add a new reply to an existing thread
     */
    public function actionNewReply($id)
    {
        $thread = Thread::model()->findByPk($id);
        if (null == $thread)
            throw new CHttpException(404, 'Thread not found.');
        if (!Yii::app()->user->isForumAdmin() && $thread->is_locked)
            throw new CHttpException(403, 'Thread is locked.');

        $model = new PostForm;
        if (isset($_POST['PostForm'])) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] != Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $model->attributes = $_POST['PostForm'];
            if ($model->validate()) {
                $post = new Post();
                $post->author_id = Yii::app()->user->id;
                $post->thread_id = $thread->id;
                $post->content = $model->content;
                $post->save(false);

                $thread->lastPost_user_id = Yii::app()->user->id;
                $thread->lastPost_time = time();
                if (Yii::app()->user->isForumAdmin() && $thread->is_locked != $model->lockthread) {
                    $thread->is_locked = $model->lockthread;
                }
                $thread->save(false);


                $this->redirect($thread->url);
            }
        }
        $this->render('postform', array(
            'thread' => $thread,
            'model' => $model,
        ));
    }

    /**
     * delete action
     * Deletes thread.
     * Will take all posts inside with it!
     */
    public function actionDelete($id)
    {
        if (!Yii::app()->request->isPostRequest || !Yii::app()->request->isAjaxRequest)
            throw new CHttpException(400, 'Invalid request');

        // First, we make sure it even exists
        $thread = Thread::model()->findByPk($id);
        if (null == $thread)
            throw new CHttpException(404, 'The requested page does not exist.');

        $thread->delete();
    }

    public function actionRe()
    {
        $threads = Thread::model()->findAll();
        foreach($threads as $item){
            $item->author_id = $item->firstPost->author_id;
            $item->created = $item->firstPost->created;
            $item->lastPost_user_id = $item->lastPost->author_id;
            $item->lastPost_time = $item->lastPost->created;
            $item->post_count = $item->postCountInternal;
            $item->save();
        }
    }

}