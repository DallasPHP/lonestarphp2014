<?php
use Aura\Marshal\Manager;
use Aura\Marshal\Type\Builder as TypeBuilder;
use Aura\Marshal\Relation\Builder as RelationBuilder;

define('CACHE_PATH', dirname(__DIR__) . '/tmp/cache');
date_default_timezone_set('America/Chicago');

//Setup App/DI Container
$app = new Silex\Application();

//Default environment and debugging
$app['environment'] = strtolower(getenv('ENVIRONMENT') ? getenv('ENVIRONMENT') : 'prod');
$app['debug']       = $app['environment'] == 'dev' ? true : false;

$app['sql'] = function() {
    $config = [
        'host' => getenv('DB1_HOST'),
        'dbname' => getenv('DB1_NAME'),
        'username' => getenv('DB1_USER'),
        'password' => getenv('DB1_PASS'),
        'port' => getenv('DB1_PORT'),
    ];

    if (isset($config['dsn']))
        throw new \Exception("Please update your SQL config in parameters.yml, using the DSN parameter is now deprecated");

    $dsn = sprintf("host=%s;port=%s;dbname=%s", $config['host'], $config['port'] ?: 3306, $config['dbname']);

    $factory = new \Aura\Sql\ConnectionFactory();
    //Hardcode depdency on MySQL. Any changes to DB engine will require significant enough changes
    $connection = $factory->newInstance('mysql', $dsn, $config['username'], $config['password']);
    $connection->connect();

    return $connection;
};

$app['marshal'] = function() {
    $manager = new \Aura\Marshal\Manager(
        new TypeBuilder,
        new RelationBuilder
    );

    $manager->setType('users', ['identity_field' => 'id']);

    $manager->setType('talks', ['identity_field' => 'id']);

    $manager->setRelation('users', 'talks', [

        // the kind of relationship
        'relationship'  => 'has_many',

        // the authors field to match against
        'native_field'  => 'id',

        // the posts field to match against
        'foreign_field' => 'user_id',
    ]);

    // each post belongs to one author
    $manager->setRelation('talks', 'users', [

        // the kind of relationship
        'relationship'  => 'belongs_to',

        // normally the second param doubles as the foreign_type, but here
        // we are using plural type names, so we need to specify the
        // foreign_type explicitly
        'foreign_type'  => 'users',

        // the posts field to match against
        'native_field'  => 'user_id',

        // the authors field to match against
        'foreign_field' => 'id',
    ]);

    return $manager;
};

$app['repository.manager'] = function() use ($app) {
    $manager = new \LSP\RepositoryManager();
    $manager->setContainer($app);

    return $manager;
};

////
// URLS
////
$app->register(new \Silex\Provider\UrlGeneratorServiceProvider());

////
// TWIG
////

if (!file_exists(CACHE_PATH . '/twig')) mkdir(CACHE_PATH . '/twig', 0755, true);
$twig_options = [
    'cache' => CACHE_PATH . '/twig',
];

if ($app['debug']) {
    unset($twig_options['cache']);
}

$app->register(new \Silex\Provider\TwigServiceProvider(), [
    'twig.options'        => $twig_options,
    'twig.path'           => dirname(__DIR__) . '/src/LSP/Views/',
//    'twig.form.templates' => [
//        'form_layout.html.twig'
//    ]
]);

// Add current_page global
$app->before(function(Symfony\Component\HttpFoundation\Request $req) use ($app) {
    $app['twig']->addGlobal('current_page', $req->get("_route"));
});

//$app['twig'] = $app->share($app->extend('twig', function($twig, $app){
//    /** @var $twig Twig_Environment */
//    $twig->addExtension(new App\Twig\Extension\Foo());
//
//    return $twig;
//}));

return $app;