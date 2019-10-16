<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
                'mailer' => [
                       'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => '74.220.219.69',
            'username' => 'nomina@cvsc.co',
            'password' => 'nomina321*',
            'port' => '25',

            
          ],

            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'second_db' => [
            'class' => 'yii\db\Connection',
            // 'dsn' => 'sqlsrv:Server=181.49.3.226;database=oasis',
            'dsn' => 'dblib:host=192.168.0.13;dbname=oasis;charset=UTF-8',
            'username' => 'moodle',
            'password' => 'moodle',
            
        ],
    ],
    'params' => $params,
];
