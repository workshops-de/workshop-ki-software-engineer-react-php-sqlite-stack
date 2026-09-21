<?php

declare(strict_types=1);

use Bookmonkey\Controller\BookController;
use Bookmonkey\Repository\BookRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// --- Database bootstrap -----------------------------------------------
$dbPath = __DIR__ . '/../database/bookmonkey.sqlite';
$schemaPath = __DIR__ . '/../database/schema.sql';

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec(file_get_contents($schemaPath)); // idempotent (CREATE TABLE IF NOT EXISTS)

$bookRepository = new BookRepository($pdo);
$bookController = new BookController($bookRepository);

// --- App bootstrap ------------------------------------------------------
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Simple CORS middleware so the Next.js dev server (different origin) can call this API.
$app->add(function (Request $request, $handler): Response {
    $response = $handler->handle($request);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->options('/{routes:.+}', function (Request $request, Response $response): Response {
    return $response;
});

$app->get('/health', function (Request $request, Response $response): Response {
    $response->getBody()->write(json_encode(['status' => 'ok']));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/books', [$bookController, 'index']);
$app->get('/books/{id}', [$bookController, 'show']);
$app->post('/books', [$bookController, 'create']);
$app->put('/books/{id}', [$bookController, 'update']);
$app->delete('/books/{id}', [$bookController, 'delete']);

$app->run();
