<?php

class MainController extends CController
{

    // лейаут
    public $layout = 'application.views.layouts.default';
    // меню
    public $menu = array();
    // крошки
    public $breadcrumbs = array();
    public $errors = array();
    public $messages = array();
    public $Title = '';
    public $headAdd = '';
    public $toCheck = '';

    public $meta = array();
    public $user;
    public $current;
    public $current_pages;

    public $settings = array();

    /**
     * @var $project Projects
     */
    public $project;


    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /*public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
*/
    public function beforeAction($action)
    {
        $o_db = Settings::model()->findAll();
        foreach ($o_db as $item) {
            $this->settings[$item->alias] = $item->value;
        }
        $this->project = Projects::model()->getProjectByDomain($_SERVER['HTTP_HOST']);
        return parent::beforeAction($action);
    }

    // флеш-нотис пользователю
    public function setNotice($message)
    {
        $this->messages[] = $message;
    }

    // флеш-ошибка пользователю
    public function setError($message)
    {
        $this->errors[] = $message;
    }

    public function genMeta(&$base)
    {
        if (isset($base->meta_title))
            $this->Title = $base->meta_title;
        if (isset($base->meta_desc))
            $this->meta['desc'] = $base->meta_desc;
        if (isset($base->meta_description))
            $this->meta['desc'] = $base->meta_description;
        if (isset($base->meta_keywords))
            $this->meta['keywords'] = $base->meta_keywords;
        if (isset($base->meta_robots))
            $this->meta['robots'] = $base->meta_robots;
        if (isset($base->meta_author))
            $this->meta['author'] = $base->meta_author;
    }
}