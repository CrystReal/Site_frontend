<?php
/**
 * Created by Alex Bond.
 * Date: 10.01.14
 * Time: 21:31
 */

class LinkPager extends CLinkPager
{
    public $prevPageLabel = "<span> ← </span> Туда";
    public $nextPageLabel = "Сюда <span>→</span>";
    public $firstPageLabel = "Первая";
    public $lastPageLabel = "Последняя";
    public $hiddenPageCssClass = "hide";
    public $header = "";

    public function init()
    {
        $this->htmlOptions['class'] = "pagination pagination-sm";
        //$this->htmlOptions['style'] = "margin: 0;";
        parent::init();
    }
}