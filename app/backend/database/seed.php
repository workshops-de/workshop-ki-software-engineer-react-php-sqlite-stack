<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/bookmonkey.sqlite';

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec(file_get_contents(__DIR__ . '/schema.sql'));

$count = (int) $pdo->query('SELECT COUNT(*) FROM books')->fetchColumn();
if ($count > 0) {
    echo "Database already seeded ({$count} books). Skipping.\n";
    exit(0);
}

$books = [
    ['9781491950357', 'Learning React', 'Modern Patterns for Developing React Apps', 'Alex Banks & Eve Porcello', "O'Reilly Media", 216, '39.99', 'https://covers.openlibrary.org/b/isbn/9781491950357-L.jpg', 'A hands-on guide to modern React, covering hooks, components, and state management.', 1],
    ['9781098130842', 'Learning PHP', 'A Gentle Introduction to the Web\'s Most Popular Language', 'David Sklar', "O'Reilly Media", 512, '49.99', 'https://covers.openlibrary.org/b/isbn/9781098130842-L.jpg', 'A friendly introduction to PHP fundamentals, from syntax to building small applications.', 1],
    ['9781098118667', 'Learning TypeScript', 'Enhance Your Web Development Skills Using Type-Safe JavaScript', 'Josh Goldberg', "O'Reilly Media", 480, '54.99', 'https://covers.openlibrary.org/b/isbn/9781098118667-L.jpg', 'A comprehensive guide to TypeScript, from basic types to advanced generics.', 1],
    ['9781492051367', 'Programming TypeScript', 'Making Your JavaScript Code More Maintainable', 'Boris Cherny', "O'Reilly Media", 254, '44.99', 'https://covers.openlibrary.org/b/isbn/9781492051367-L.jpg', 'Explains how to use TypeScript to build reliable, scalable JavaScript applications.', 2],
    ['9781617294136', 'SQLite: Small. Fast. Reliable.', null, 'Michael Owens', 'Apress', 384, '34.99', 'https://covers.openlibrary.org/b/isbn/9781617294136-L.jpg', 'A deep dive into the design and usage of the SQLite database engine.', 2],
    ['9781593279509', 'Eloquent JavaScript', 'A Modern Introduction to Programming', 'Marijn Haverbeke', 'No Starch Press', 472, '39.99', 'https://covers.openlibrary.org/b/isbn/9781593279509-L.jpg', 'A modern, accessible introduction to programming with JavaScript.', 2],
    ['9781098131641', 'Modern PHP', 'New Features and Good Practices', 'Josh Lockhart', "O'Reilly Media", 254, '34.99', 'https://covers.openlibrary.org/b/isbn/9781098131641-L.jpg', 'A tour through modern PHP features and best practices for clean, maintainable code.', 3],
    ['9781098136657', 'Learning Next.js', 'Full Stack React Applications', 'Lindsay Levine', "O'Reilly Media", 320, '49.99', 'https://covers.openlibrary.org/b/isbn/9781098136657-L.jpg', 'A practical guide to building full-stack applications with Next.js and React.', 3],
    ['9781449331818', 'Learning JavaScript Design Patterns', null, 'Addy Osmani', "O'Reilly Media", 254, '29.99', 'https://covers.openlibrary.org/b/isbn/9781449331818-L.jpg', 'A guide to proven design patterns for writing organized, maintainable JavaScript.', 3],
    ['9781098106759', 'API Design Patterns', null, 'JJ Geewax', 'Manning', 416, '54.99', 'https://covers.openlibrary.org/b/isbn/9781098106759-L.jpg', 'A catalogue of design patterns for building consistent, evolvable APIs.', 1],
];

$stmt = $pdo->prepare(
    'INSERT INTO books (isbn, title, subtitle, author, publisher, num_pages, price, cover, abstract, user_id)
     VALUES (:isbn, :title, :subtitle, :author, :publisher, :num_pages, :price, :cover, :abstract, :user_id)'
);

foreach ($books as [$isbn, $title, $subtitle, $author, $publisher, $numPages, $price, $cover, $abstract, $userId]) {
    $stmt->execute([
        ':isbn' => $isbn,
        ':title' => $title,
        ':subtitle' => $subtitle,
        ':author' => $author,
        ':publisher' => $publisher,
        ':num_pages' => $numPages,
        ':price' => $price,
        ':cover' => $cover,
        ':abstract' => $abstract,
        ':user_id' => $userId,
    ]);
}

echo 'Seeded ' . count($books) . " books.\n";
