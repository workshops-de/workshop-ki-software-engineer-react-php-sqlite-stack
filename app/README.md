<h1 align="center">Bookmonkey</h1>

<p align="center">
  <em>The companion app for the "KI Software Engineer" workshop — React (TypeScript) frontend + PHP/SQLite backend</em>
</p>

Bookmonkey is a small book-catalog application that participants extend and refactor throughout the
workshop tasks. It mirrors the domain of the original Angular-based Bookmonkey workshop app, but ships
with its **own** PHP/Slim backend and SQLite database instead of an external fake-data API — so
participants get hands-on with both the frontend and the backend AI-assisted workflows.

The seed data (50 books, incl. cover images) is sourced from
[workshops-de/bookmonkey-api](https://github.com/workshops-de/bookmonkey-api) v4.2.0 — the reference
dataset for the Bookmonkey workshop app. Covers are copied into `backend/public/covers/` and served
directly by this backend (no dependency on an external API or CDN).

## Stack

- **Frontend:** `frontend/` — Next.js (App Router) + TypeScript + Tailwind CSS
- **Backend:** `backend/` — PHP 8.3 + [Slim Framework](https://www.slimframework.com/) + SQLite (via PDO)
- **Local dev:** Docker Compose (no online playground/StackBlitz — everything runs locally)

## Quick Start

```bash
docker compose up --build
```

- Frontend: http://localhost:3000
- Backend API: http://localhost:8080 (try http://localhost:8080/health)

The backend container runs the SQLite migration and seeds 50 sample books (with real covers) on
first start. The database lives in a named Docker volume, so it persists across rebuilds — run
`docker compose down -v` to reset it to the original seed data.

## Running Without Docker

### Backend

```bash
cd backend
composer install
composer run migrate
composer run seed
composer start   # php -S 0.0.0.0:8080 -t public
```

### Frontend

```bash
cd frontend
npm install
npm run dev
```

Set `NEXT_PUBLIC_API_URL` if the backend does not run on `http://localhost:8080`.

## API Reference

| Method | Path          | Description                                  |
| ------ | ------------- | --------------------------------------------- |
| GET    | `/health`     | Health check                                   |
| GET    | `/books`      | List books, supports `?q=` (search) and `?_limit=` |
| GET    | `/books/{id}` | Get a single book                              |
| POST   | `/books`      | Create a book                                  |
| PUT    | `/books/{id}` | Update a book                                  |
| DELETE | `/books/{id}` | Delete a book                                  |

## Testing

```bash
cd backend && composer test    # PHPUnit
cd frontend && npm run test    # Vitest + React Testing Library
```

## Git Tags

Lesson tasks reference specific commits in this repository via `git_tag_starting` (lesson-level) and
`git_tag_completed` (task-level) in the corresponding `lesson.yml` / `task.yml` files. As the workshop
content is authored and taught, tag each reference-solution commit accordingly (see
`.cursor/skills/lesson-migration` and the git conventions in `.cursor/rules/git-conventions.mdc`).
