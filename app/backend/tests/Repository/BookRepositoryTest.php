<?php

declare(strict_types=1);

namespace Bookmonkey\Tests\Repository;

use Bookmonkey\Repository\BookRepository;
use PDO;
use PHPUnit\Framework\TestCase;

final class BookRepositoryTest extends TestCase
{
    private BookRepository $repository;

    protected function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec(file_get_contents(__DIR__ . '/../../database/schema.sql'));

        $this->repository = new BookRepository($pdo);
    }

    public function test_it_creates_and_finds_a_book_by_id(): void
    {
        $created = $this->repository->create([
            'isbn' => '9781234567897',
            'title' => 'Test Driven PHP',
            'author' => 'Ada Lovelace',
        ]);

        $found = $this->repository->findById((int) $created['id']);

        $this->assertNotNull($found);
        $this->assertSame('Test Driven PHP', $found['title']);
    }

    public function test_it_searches_books_by_title_or_author(): void
    {
        $this->repository->create(['isbn' => '1', 'title' => 'Learning React', 'author' => 'Alex Banks']);
        $this->repository->create(['isbn' => '2', 'title' => 'Learning PHP', 'author' => 'David Sklar']);

        $results = $this->repository->findAll(10, 'React');

        $this->assertCount(1, $results);
        $this->assertSame('Learning React', $results[0]['title']);
    }

    public function test_it_returns_null_when_book_does_not_exist(): void
    {
        $this->assertNull($this->repository->findById(999));
    }
}
