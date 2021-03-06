<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wEZ7iu5O6gLw1qOCVQiuWwles7vOsUSX',
            'parsers' => ['application/json'=>'yii\web\JsonParser']

        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                            'class' => 'Swift_SmtpTransport',
                            'host' => 'smtp.gmail.com',
                            'username' => 'rickz.avenger@gmail.com',
                            'password' => 'koplaktenand',
                            'port' => '587',
                            'encryption' => 'tls',
                            'streamOptions' => [
                                                    'ssl' => [
                                                        'verify_peer' => false,
                                                        'allow_self_signed' => true
                                                    ],
                                                ],
                           ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'class'=>'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                /*'class' => 'yii\rest\UrlRule',
                    'controller' => ['services'],
                    'tokens' => 
                        [
                            '{id}' => '<id:\\w+>'
                        ]*/
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
