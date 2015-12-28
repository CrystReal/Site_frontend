<?php

class ForumModule extends CWebModule
{
    public $defaultController = 'forum';

    public $userUrl;

    /**
     * These classes can overrride the htmlOptions->class parameters passed when
     * rendering the table and listview. When not set, a css file will be loaded
     * that makes the listview look like a gridview
     */
    public $forumTableClass;
    public $forumListviewClass;
    public $forumDetailClass;

    /*
     * Date and time formats, and the oprtion to replace the date with either
     * "Today" or "Yesterday" if appropriate.
     */
    public $dateFormatShort = 'j.m.Y';
    public $dateFormatLong = 'j.m.Y';
    public $dateReplaceWords = true;
    public $timeFormatShort = 'H:i';
    public $timeFormatLong = 'H:i';

    /**
     * The number of threads/posts to display per page
     */
    public $threadsPerPage = 20;
    public $postsPerPage = 20;

    public function init()
    {
        $this->setImport(array(
            'forum.components.*',
            'forum.models.*',
        ));
    }

    /**
     * This doesn't belong here at all, but it's globally accessible...
     */
    public function format_date($timestamp, $format='long')
    {
        if('long' == $format)
        {
            $dateFormat = $this->dateFormatLong;
            $timeFormat = $this->timeFormatLong;
        } else {
            $dateFormat = $this->dateFormatShort;
            $timeFormat = $this->timeFormatShort;
        }

        $date = date($dateFormat, $timestamp);
        $time = date($timeFormat, $timestamp);

        if($this->dateReplaceWords)
        {
            if($date == date($dateFormat)) $date = 'Сегодня';
            elseif($date == date($dateFormat, time()-86400)) $date = 'Вчера';
        }

        return $date .' в '. $time;
    }

}