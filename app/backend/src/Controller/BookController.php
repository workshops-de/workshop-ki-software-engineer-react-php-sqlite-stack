<?php

declare(strict_types=1);

namespace Bookmonkey\Controller;

use Bookmonkey\Repository\BookRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class BookController
{
    public function __construct(private readonly BookRepository $books)
    {
    }

    public function index(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $limit = isset($params['_limit']) ? (int) $params['_limit'] : 10;
        $search = $params['q'] ?? null;

        $books = $this->books->findAll($limit, $search);
        $serialize = fn (array $book): array => $this->serialize($book, $request);

        return $this->json($response, array_map($serialize, $books));
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $book = $this->books->findById((int) $args['id']);

        if ($book === null) {
            return $this->json($response, ['error' => 'Book not found'], 404);
        }

        return $this->json($response, $this->serialize($book, $request));
    }

    public function create(Request $request, Response $response): Response
    {
        $data = (array) $request->getParsedBody();
        $book = $this->books->create($data);

        return $this->json($response, $this->serialize($book, $request), 201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = (array) $request->getParsedBody();
        $book = $this->books->update((int) $args['id'], $data);

        if ($book === null) {
            return $this->json($response, ['error' => 'Book not found'], 404);
        }

        return $this->json($response, $this->serialize($book, $request));
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $deleted = $this->books->delete((int) $args['id']);

        if (!$deleted) {
            return $this->json($response, ['error' => 'Book not found'], 404);
        }

        return $response->withStatus(204);
    }

    /**
     * Maps the snake_case database row to the camelCase shape the frontend expects.
     * Cover paths are stored relative (e.g. "/covers/9780747532699.png") and resolved
     * to an absolute URL here, so the frontend can render them directly.
     */
    private function serialize(array $book, Request $request): array
    {
        return [
            'id' => (string) $book['id'],
            'isbn' => $book['isbn'],
            'title' => $book['title'],
            'subtitle' => $book['subtitle'],
            'author' => $book['author'],
            'publisher' => $book['publisher'],
            'numPages' => $book['num_pages'] !== null ? (int) $book['num_pages'] : null,
            'price' => $book['price'],
            'cover' => $this->resolveCoverUrl($book['cover'], $request),
            'abstract' => $book['abstract'],
            'userId' => (int) $book['user_id'],
        ];
    }

    private function resolveCoverUrl(?string $cover, Request $request): ?string
    {
        if ($cover === null || $cover === '' || str_starts_with($cover, 'http')) {
            return $cover;
        }

        $uri = $request->getUri();

        return $uri->getScheme() . '://' . $uri->getAuthority() . $cover;
    }

    private function json(Response $response, mixed $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
