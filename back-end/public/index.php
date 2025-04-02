<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: false");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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
