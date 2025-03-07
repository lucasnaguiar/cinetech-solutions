<?php
header("Access-Control-Allow-Origin: *"); // Permite todas as origens
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Métodos HTTP permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Cabeçalhos permitidos

// load composer dependencies
require '../vendor/autoload.php';
$PATH = dirname(__FILE__, 2);

$dotenv = Dotenv\Dotenv::createImmutable($PATH);
$dotenv->load();
require_once __DIR__ . '/../bootstrap.php';

// Load our helpers
require_once '../app/helpers.php';

// Load our custom routes
require_once '../routes/web.php';



use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::enableMultiRouteRendering(false);
// Start the routing
echo SimpleRouter::start();
