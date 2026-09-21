<?php

declare(strict_types=1);

namespace Bookmonkey\Repository;

use PDO;

final class BookRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function findAll(int $limit = 10, ?string $search = null): array
    {
        if ($search !== null && $search !== '') {
            $stmt = $this->pdo->prepare(
                'SELECT * FROM books
                 WHERE title LIKE :search OR author LIKE :search
                 ORDER BY title ASC
                 LIMIT :limit'
            );
            $stmt->bindValue(':search', '%' . $search . '%');
        } else {
            $stmt = $this->pdo->prepare('SELECT * FROM books ORDER BY title ASC LIMIT :limit');
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM books WHERE id = :id');
        $stmt->execute([':id' => $id]);

        $book = $stmt->fetch();

        return $book === false ? null : $book;
    }

    public function create(array $data): array
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO books (isbn, title, subtitle, author, publisher, num_pages, price, cover, abstract, user_id)
             VALUES (:isbn, :title, :subtitle, :author, :publisher, :num_pages, :price, :cover, :abstract, :user_id)'
        );

        $stmt->execute([
            ':isbn' => $data['isbn'],
            ':title' => $data['title'],
            ':subtitle' => $data['subtitle'] ?? null,
            ':author' => $data['author'],
            ':publisher' => $data['publisher'] ?? null,
            ':num_pages' => $data['numPages'] ?? null,
            ':price' => $data['price'] ?? null,
            ':cover' => $data['cover'] ?? null,
            ':abstract' => $data['abstract'] ?? null,
            ':user_id' => $data['userId'] ?? 1,
        ]);

        return $this->findById((int) $this->pdo->lastInsertId());
    }

    public function update(int $id, array $data): ?array
    {
        $existing = $this->findById($id);
        if ($existing === null) {
            return null;
        }

        $merged = array_merge($existing, $data);

        $stmt = $this->pdo->prepare(
            'UPDATE books SET
                isbn = :isbn, title = :title, subtitle = :subtitle, author = :author,
                publisher = :publisher, num_pages = :num_pages, price = :price,
                cover = :cover, abstract = :abstract, updated_at = datetime(\'now\')
             WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $id,
            ':isbn' => $merged['isbn'],
            ':title' => $merged['title'],
            ':subtitle' => $merged['subtitle'],
            ':author' => $merged['author'],
            ':publisher' => $merged['publisher'],
            ':num_pages' => $merged['num_pages'],
            ':price' => $merged['price'],
            ':cover' => $merged['cover'],
            ':abstract' => $merged['abstract'],
        ]);

        return $this->findById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM books WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
