<?php
$gridColumns = array(
    array(
        'name' => 'Название',
        'headerHtmlOptions' => array('colspan' => '2'),
        'type' => 'html',
        'value' => '$data->getIcon()',
        'htmlOptions' => array('style' => 'width:20px;font-size: 25px;'),
    ),
    array(
        'name' => 'subject',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'type' => 'html',
        'value' => '$data->renderSubjectCell()',
    ),
    array(
        'name' => 'Последнее сообщение',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'type' => 'html',
        'value' => '$data->renderLastpostCell()',
        'htmlOptions' => array('style' => 'width:200px;'),
    ),
    array(
        'name' => 'post_count',
        'header' => 'Сообщения',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'htmlOptions' => array('style' => 'width:65px; text-align:center; font-weight: bold;'),
    ),
    array(
        'name' => 'view_count',
        'header' => 'Просмотры',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'htmlOptions' => array('style' => 'width:65px; text-align:center; font-weight: bold;'),
    ),
);
$newTopic = "";
$isAdmin = !Yii::app()->user->isGuest && Yii::app()->user->isForumAdmin();
if (isset($_GET['id']) && $_GET['id'] > 0 && (!$forum->is_locked || $isAdmin)) {
    $newTopic = '<a href="' . $this->createUrl('/forum/thread/create', ['id' => $forum->id]) . '" class="btn btn-primary btn-sm pull-right">Новая тема</a>';
}

echo $newTopic;
$this->widget('LinkPager', ['pages' => $threadsProvider->pagination, "htmlOptions"=>["class"=>'pagination pagination-sm pull-left']]);
$this->widget('forum.extensions.groupgridview.GroupGridView', array(
    'enableSorting' => false,
    'selectableRows' => 0,
    'dataProvider' => $threadsProvider,
    'template' => '{items}',
    'columns' => $gridColumns,
    'emptyText' => 'Форум пуст.',
));