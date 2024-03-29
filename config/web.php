<?php
/** @var $app \Silex\Application */
$app = require __DIR__ . '/common.php';

////
// ORLEX
////
$app->register(new \Orlex\ServiceProvider(),[
    'orlex.cache.dir'       => CACHE_PATH . '/orlex',
    'orlex.controller.dirs' => [
        dirname(__DIR__) . '/src/LSP/Controller'
    ],
//    'orlex.annotation.dirs' => [
//        dirname(__DIR__) . '/src' => 'App\Annotation'
//    ]
]);

////
// FORMS
////
$app->register(new \Silex\Provider\ValidatorServiceProvider());
$app->register(new \Silex\Provider\TranslationServiceProvider());

$app->register(new \Silex\Provider\FormServiceProvider(), [
    'form.secret' => 'lonestarphp2014',
]);

////
// SESSIONS
////
$app->register(new Silex\Provider\SessionServiceProvider());

return $app;