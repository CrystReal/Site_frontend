<?php

/**
 * Created by Alex Bond.
 * Date: 14.11.13
 * Time: 19:58
 */
class StatsModule extends CWebModule
{
    public function init()
    {
        $this->setImport(array(
            'application.modules.stats.models.*',
        ));
    }
}