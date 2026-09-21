## Overview

Turn your agreed domain model into a real, migrated SQLite database with seed data, using plain
PHP and PDO. You will practise giving the agent a precise specification (your model) and
**verifying the result** — including letting the agent self-correct when a migration fails.

## Background

This stack has no ORM: PDO talks to SQLite directly, a `schema.sql` file is the single source of
truth for structure, and a small `migrate.php` script applies it (`CREATE TABLE IF NOT EXISTS`
keeps it idempotent). One wrinkle: SQLite has no native enums, so status- and type-like fields
(e.g. a borrow request's `pending` / `accepted` / `rejected`) are stored as documented `TEXT`
columns with the allowed values written down, not enforced by the database — this repo's own
`app/backend/database/schema.sql` and `seed.php` show the pattern (reference only, write your own).

## Steps

1. Give the agent your entity model and ask it to draft `schema.sql` for every entity, with the
   correct foreign keys and any uniqueness constraint you identified.
2. Review the schema against your glossary: optional relationships (nullable foreign keys), unique
   constraints (`UNIQUE` / a composite unique index), and status/type fields represented as
   documented `TEXT` values.
3. Have the agent write and run `migrate.php` against a local SQLite file. If it fails (a
   syntax error, a missing `PRAGMA foreign_keys = ON`), let the agent read the error and correct
   itself.
4. Ask the agent to write a `seed.php` with a realistic spread of demo data — several books, users,
   and borrow requests in different states.
5. **Verify** by querying the database directly (`sqlite3 your.db "SELECT * FROM ...;"` or a GUI
   like DB Browser for SQLite) and confirming it matches your model.
6. Record the database commands (migrate, seed, and how to reset/re-seed) in your project memory.

## Success Criteria

- [ ] `schema.sql` models all entities with correct foreign keys and unique constraints
- [ ] `migrate.php` applies cleanly and is safe to re-run (idempotent)
- [ ] `seed.php` runs and populates demo data you can query
- [ ] Foreign keys are actually enforced (`PRAGMA foreign_keys = ON` is set on every connection)

## Pitfalls (SQLite via PDO)

- SQLite does **not** enforce foreign keys by default — you must set
  `$pdo->exec('PRAGMA foreign_keys = ON');` on every new connection, or "impossible" states become
  possible.
- There is no native `ENUM` type — document the allowed `TEXT` values in `schema.sql` comments and
  validate them in PHP before inserting.
- `AUTOINCREMENT` on `INTEGER PRIMARY KEY` is usually unnecessary overhead in SQLite — a plain
  `INTEGER PRIMARY KEY` already auto-increments rowids; only add `AUTOINCREMENT` if you specifically
  need monotonic IDs that never get reused.
- Concurrent writers can hit `SQLITE_BUSY` — enable WAL mode (`PRAGMA journal_mode = WAL;`) if you
  seed data while the dev server is also writing.

## References

- SQLite — `CREATE TABLE` / datatypes: https://sqlite.org/lang_createtable.html
- SQLite — Foreign key support: https://sqlite.org/foreignkeys.html
- PHP — PDO SQLite driver: https://www.php.net/manual/en/ref.pdo-sqlite.php
