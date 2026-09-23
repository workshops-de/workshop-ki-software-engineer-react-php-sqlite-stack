## Overview

Build your first full feature slice — list, detail, create, and edit screens for **books** — on
top of the established read/write architecture, styled with plain Tailwind CSS and validated with
a form library. You will give the agent the project's repeating "shape" for a feature and reuse
it, so every feature you add stays consistent.

## Prerequisites

- None external.

## Background

The application is API-first: **reads** happen by fetching from PHP REST endpoints (in a Server
Component when the data doesn't depend on client interaction, or a client component when it does,
as you already built for the book list); **writes** happen by `POST`/`PUT`-ing to a PHP endpoint
that validates input, persists to SQLite, and returns the updated resource. Validation rules
should exist in exactly one place *per side* — a Zod schema on the frontend for instant form
feedback, and the equivalent checks in PHP because the frontend can never be trusted to have run
them. Keep the UI plain: hand-rolled components styled with Tailwind utility classes, no
component-registry CLI.

## Steps

1. Plan the **books** feature covering **list, detail, create, and edit**. Decide the list's
   search, filter, and sort behaviour (you already have a starting point in `app/frontend`).
2. Implement **reads** by fetching from the corresponding PHP endpoint; implement **writes** by
   calling a PHP endpoint that validates input, persists via PDO, and returns the
   updated/created resource as JSON.
3. Build the screens with plain, hand-written components, including a form that surfaces
   validation errors clearly (both the frontend's Zod errors and any error the backend returns).
4. Verify the whole slice in the browser: create a book, view it, edit it, and see the list
   update.
5. Once the shape feels solid, apply the **same shape** to a second, smaller entity (for example,
   reviews on a book) to prove the pattern reuses cleanly. Note where the only differences are.
6. Capture the feature pattern in your project memory for future reuse.

## Success Criteria

- [ ] The book list supports search and sort; results update on submit
- [ ] Create/Edit call a validated PHP endpoint and the list/detail refreshes afterward
- [ ] The detail page renders a single book with all its fields
- [ ] `tsc --noEmit` and `npm run build` pass on the frontend; the backend returns 4xx with a clear
      message on invalid input, not a 500

## Pitfalls (this stack)

- `params` and `searchParams` are **Promises** on recent Next.js — `await` them in pages.
- SQLite's `LIKE` is **case-insensitive for ASCII by default** but **case-sensitive for non-ASCII**
  characters — decide if that matters for your search (Bookmonkey's search already relies on this;
  check `BookRepository::findAll`).
- The PHP endpoint is the actual validation boundary — client-side checks are for UX, not
  security; the backend must re-validate everything.
- Returning PHP's default error pages (HTML) instead of JSON on failure will silently break the
  frontend's error handling — always return `Content-Type: application/json`, even on errors.

## References

- Next.js — Server and Client Components: https://nextjs.org/docs/app/building-your-application/rendering/composition-patterns
- Tailwind CSS — Utility-first fundamentals: https://tailwindcss.com/docs/styling-with-utility-classes
- Zod — Schema validation: https://zod.dev
- Slim Framework — Request/Response: https://www.slimframework.com/docs/v4/objects/request.html
