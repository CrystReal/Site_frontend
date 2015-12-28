<?php

return array(
    'import' => array(
        'application.components.*',
        'application.models.*',
        'application.models.enums.*',
        'application.views.widgets.*',
        'application.helpers.AlexBond',
    ),
    'sourceLanguage' => 'ru',
    //'preload' => array('log', 'debug'),
    'defaultController' => 'Static',
    'homeUrl' => '/',
    'components' => array(
        'request' => array(
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '/' => 'Static/index',
                '/start' => "Start/index",
                '/avatar/<username>/<size>' => 'personal/profile/avatar',
                '/u/' => 'personal/profile/list',
                '/u/<id:\d+>.<nickname>' => 'personal/profile/view',
                '/login' => "personal/auth/index",
                '/a/<a>' => "personal/auth/<a>",
                '/c' => "personal/cabinet/index",
                '/c/<a>' => "personal/cabinet/<a>",
                '/f' => "personal/friends/friends",
                '/f/<a>' => "personal/friends/<a>",
                "support" => "personal/support/list",
                "support/<a>" => "personal/support/<a>",
                "team" => "team/list",
                "news" => "news/list",
                "forum/<id:\d+>" => "forum/forum/index",
                "forum" => "forum/forum/index",
                "forum/t/<id:\d+>" => "forum/thread/view",
                "forum/t/<a>" => "forum/thread/<a>",
                '/<module>/<c>/<a>' => "<module>/<c>/<a>",
                "/<id:\d+>-<alias>" => "Static/static",

                array('class' => 'application.components.StaticUrlRule'),
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'Error/error',
        ),
        'user' => array(
            'class' => 'UserComponent',
            'loginUrl' => array('/personal/auth/index'),
            'allowAutoLogin' => true
        ),
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=crmc',
            'username' => 'root',
            'password' => '',
            'emulatePrepare' => true, // необходимо для некоторых версий инсталляций MySQL
            'charset' => 'utf8',
            //'enableProfiling' => TRUE,
            //'enableParamLogging' => true,
            'schemaCachingDuration' => 3600,
        ),
        "redis" => array(
            "class" => "ext.YiiRedis.ARedisConnection",
            "hostname" => "localhost",
            "port" => 6379,
            "database" => 10,
            "prefix" => ""
        ),
        "redisCache" => array(
            "class" => "ext.YiiRedis.ARedisConnection",
            "hostname" => "localhost",
            "port" => 6379,
            "database" => 11,
            "prefix" => ""
        ),
        'cache' => [
            "class" => "ext.YiiRedis.ARedisCache",
            "connection" => "redisCache"
        ],
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            /*'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.gmail.com',
                'username' => 'XXXX@gmail.com',
                'password' => 'XXXX',
                'port' => '465',
                'encryption'=>'tls',
            ),*/
            'viewPath' => 'application.views.emailTemplates',
            'logging' => true,
            'dryRun' => false
        ),
        /* 'log' => array(
             'class' => 'CLogRouter',
             'routes' => array(
                 array(
                     'class' => 'CFileLogRoute',
                     'levels' => 'trace, info, error, warning',
                 ),
             ),
         ),*/
        /*'debug' => array(
            'class' => 'ext.yii2-debug.Yii2Debug',
            'allowedIPs' => array('76.168.143.156')
        ),*/
    ),
    'modules' => array(
        "personal", "stats", "forum"
    ),
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'no-reply@crystreal.net',
        'siteUrl' => 'http://crystreal.net',
        'storeImages' => array(
            'path' => 'static/uploads/',
            'thumbPath' => 'static/assets/',
            'maxFileSize' => 10 * 1024 * 1024,
            'extensions' => array('jpg', 'jpeg', 'png', 'gif'),
            'types' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png'),
            'url' => '/static/uploads/', // With ending slash
            'thumbUrl' => '/static/assets/', // With ending slash
            'sizes' => array(
                'resizeMethod' => 'resize', // resize/adaptiveResize
                'resizeThumbMethod' => 'resize', // resize/adaptiveResize
                'maximum' => array(800, 600), // All uploaded imagesMainController.php
            )
        ),
        'staticPath' => "static",
        'tmpPath' => 'static/tmp/',
        'gameTypes' => [
            1 => [
                "name" => "DefKill",
                "url" => "defKill",
                "isTeams" => true,
                "teams" => [
                    1 => "<span class='label red'>Крассная</span>",
                    2 => "<span class='label blue'>Синяя</span>",
                    3 => "<span class='label green'>Зеленая</span>",
                    4 => "<span class='label yellow'>Желтая</span>"
                ]
            ],
            2 => [
                "name" => "QuakeCraft",
                "url" => "quakeCraft",
                "isTeams" => false
            ],
            3 => [
                "name" => "BowSpleef",
                "url" => "bowSpleef",
                "isTeams" => false
            ],
            4 => [
                "name" => "TNTRun",
                "url" => "tntRun",
                "isTeams" => false
            ],
        ]
    ),
);