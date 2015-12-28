<?php

$isAdmin = !Yii::app()->user->isGuest && Yii::app()->user->isForumAdmin();

$gridColumns = array(
    array(
        'name' => 'Форум',
        'headerHtmlOptions' => array('colspan' => '2'),
        'type' => 'html',
        'value' => 'CHtml::image(Yii::app()->controller->module->registerImage("on.gif"), "On")',
        'htmlOptions' => array('style' => 'width:22px;'),
    ),
    array(
        'name' => 'forum',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'type' => 'html',
        'value' => '$data->renderForumCell()',
    ),
    /*array(
        'name' => 'threadCount',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'header' => 'Темы',
        'htmlOptions' => array('style' => 'width:65px; text-align:center;'),
    ),
    array(
        'name' => 'postCount',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'header' => 'Сообщения',
        'htmlOptions' => array('style' => 'width:65px; text-align:center;'),
    ),*/
    array(
        'name' => 'Последнее сообщение',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'type' => 'html',
        'value' => '$data->renderLastpostCell()',
        'htmlOptions' => array('style' => 'width:200px;'),
    ),
);

if (isset($inforum) && $inforum == true)
    $preheader = '<div style="text-align:center;">Форумы в "' . CHtml::encode($forum->title) . '"</div>';
else
    $preheader = '<h4>' . CHtml::encode($forum->title) . '</h4>';

// Add some admin controls
if ($isAdmin) {
    $deleteConfirm = "Are you sure? All subforums and threads are permanently deleted as well!";

    $adminheader =
        '<div class="admin" style="float:right; font-size:smaller;">' .
        CHtml::link('Новый форум', array('/forum/forum/create', 'parentid' => $forum->id)) . ' | ' .
        CHtml::link('Редактировать', array('/forum/forum/update', 'id' => $forum->id)) . ' | ' .
        CHtml::ajaxLink('Удалить категорию',
            array('/forum/forum/delete', 'id' => $forum->id),
            array('type' => 'POST', 'success' => 'function(){document.location.reload(true);}'),
            array('confirm' => $deleteConfirm)
        ) .
        '</div>';

    $preheader = $adminheader . $preheader;

    // Admin links to show in extra column
    $gridColumns[] = array(
        'class' => 'CButtonColumn',
        'header' => 'Админ',
        'template' => '{delete}{update}',
        'deleteConfirmation' => "js:'" . $deleteConfirm . "'",
        'afterDelete' => 'function(){document.location.reload(true);}',
        'buttons' => array(
            'delete' => array('url' => 'Yii::app()->createUrl("/forum/forum/delete", array("id"=>$data->id))'),
            'update' => array('url' => 'Yii::app()->createUrl("/forum/forum/update", array("id"=>$data->id))'),
        ),
        'htmlOptions' => array('style' => 'width:40px;'),
    );
}

$this->widget('forum.extensions.groupgridview.GroupGridView', array(
    'enableSorting' => false,
    'summaryText' => '',
    'selectableRows' => 0,
    'emptyText' => 'Нет форумов',
    'showTableOnEmpty' => $isAdmin,
    'preHeader' => $preheader,
    'preHeaderHtmlOptions' => array(
        'class' => 'preheader',
    ),
    'dataProvider' => $subforums,
    'columns' => $gridColumns,
    "onlyPreHeader" => true,
    'htmlOptions' => array(
        'class' => Yii::app()->controller->module->forumTableClass,
    )
));
