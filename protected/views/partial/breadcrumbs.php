<?php
if (isset(Yii::app()->controller->breadcrumbs) && ($cnt = count(Yii::app()->controller->breadcrumbs)) > 0) {
    echo '<ol class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#" itemprop="breadcrumb">';
    $cnt = count(Yii::app()->controller->breadcrumbs);
    $i = 1;
    echo '<li> <a title="Главная" href="/">Главная</a></li>';
    foreach (Yii::app()->controller->breadcrumbs as $item) {
        if (isset($item['isCat']))
            echo '<li ' . ($i == $cnt ? '' : 'typeof="v:Breadcrumb"') . '>' . $item['title'] . '</li>';
        else
            echo '<li ' . ($i == $cnt ? '' : 'typeof="v:Breadcrumb"') . '><a title="' . CHtml::encode($item['title']) . '" href="' . $item['url'] . '" rel="v:url" property="v:title">' . $item['title'] . '</a></li>';
        $i++;
    }
    echo '</ol>';
}