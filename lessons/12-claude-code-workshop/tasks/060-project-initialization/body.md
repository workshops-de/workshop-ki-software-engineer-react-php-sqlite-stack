## Overview

Turn an empty repository into a running web application skeleton, with the agent doing the
mechanical work while **you steer with a reviewed plan**. This is where your own version of
Bookmonkey begins to take shape — a small, deliberately simple book-catalog app with a React
frontend and its own PHP backend.

## Background

Scaffolding is repetitive and well-documented — an ideal job to delegate to the agent. But
delegation without review invites surprises, so you use planning mode to see and approve the
approach first, then verify both halves of the stack actually boot before declaring success. The
target stack is **two separate applications in one repo, no external services required**: a
Next.js App Router frontend in TypeScript styled with plain Tailwind CSS, talking over HTTP to a
PHP backend ([Slim Framework](https://www.slimframework.com/)) backed by a local SQLite file —
see this repo's own `app/frontend` and `app/backend` for the reference shape (domain inspiration
only, not starter code for this task). Everything here runs on `localhost`; nothing calls out to a
third-party service.

## Steps

1. In your empty repository, ask the agent — **in planning mode** — to propose how it would
   scaffold both halves of the stack. Review the plan and push back on anything beyond what you
   need (in particular: no hosting/deployment integration, no third-party UI kit — plain Tailwind
   is enough).
2. Approve the plan and let the agent execute the **frontend** first. Establish a separation
   between a **public area** (for sign-in/registration later) and an **authenticated application
   area** (the main shell), using route groups.
3. Configure Tailwind and confirm one sample styled element renders.
4. Let the agent scaffold the **backend**: a PHP project with Slim, a `public/index.php` entry
   point, and a SQLite connection via PDO. Add one throwaway `/health` route.
5. **Verify both halves independently, fully offline**: start the frontend dev server and open it
   in a browser; start the backend (`php -S 0.0.0.0:8080 -t public`) and confirm `/health`
   responds.
6. Review the changes and make your first commit with a clear message.

## Success Criteria

- [ ] `npm run dev` serves the frontend and the shell renders — with no network requests beyond
      `localhost` in the browser's dev tools
- [ ] Type-check and `npm run build` both pass on the frontend
- [ ] A public route group and an authenticated route group both exist and render
- [ ] The backend's `/health` endpoint responds with a 200 over PHP's built-in server
- [ ] The scaffold is committed with a message you reviewed

## References

- Next.js — App Router docs: https://nextjs.org/docs/app
- Tailwind CSS — Installation: https://tailwindcss.com/docs/installation
- Next.js — Route groups: https://nextjs.org/docs/app/building-your-application/routing/route-groups
- Slim Framework — Installation: https://www.slimframework.com/docs/v4/start/installation.html
