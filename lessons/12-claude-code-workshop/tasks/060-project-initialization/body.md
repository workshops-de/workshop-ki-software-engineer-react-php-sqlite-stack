## Overview

Turn an empty repository into a running web application skeleton, with the agent doing the
mechanical work while **you steer with a reviewed plan**. This is where your own version of
Bookmonkey begins to take shape — a small book-catalog app with a React frontend and its own PHP
backend.

## Prerequisites

- **Required skill:** `shadcn` (`npx skills add vercel/vercel-plugin@shadcn -y`) — the shadcn CLI is
  interactive and its flags change frequently; this skill keeps the agent on current commands.
- Recommended: `react-best-practices`, `frontend-design`.

## Background

Scaffolding is repetitive and well-documented — an ideal job to delegate to the agent. But
delegation without review invites surprises, so you use planning mode to see and approve the
approach first, then verify both halves of the stack actually boot before declaring success. The
target stack is **two separate applications in one repo**: a Next.js App Router frontend in
TypeScript (styled with Tailwind CSS and shadcn/ui) that talks over HTTP to a PHP backend (the
[Slim Framework](https://www.slimframework.com/)) backed by SQLite — see this repo's own
`app/frontend` and `app/backend` for the reference shape (domain inspiration only, not starter
code for this task).

## Steps

1. In your empty repository, ask the agent — **in planning mode** — to propose how it would
   scaffold both halves of the stack. Review the plan and push back on anything beyond what you
   need.
2. Approve the plan and let the agent execute the **frontend** first. Establish a separation
   between a **public area** (for sign-in/registration later) and an **authenticated application
   area** (the main shell), using route groups.
3. Configure the styling layer and component library, and confirm a sample component renders.
4. Let the agent scaffold the **backend**: a PHP project with Slim, a `public/index.php` entry
   point, and a SQLite connection via PDO. Add one throwaway `/health` route.
5. **Verify both halves independently**: start the frontend dev server and open it in a browser;
   start the backend (`php -S 0.0.0.0:8080 -t public`) and confirm `/health` responds.
6. Review the changes and make your first commit with a clear message.

## Success Criteria

- [ ] `npm run dev` serves the frontend and the shell renders
- [ ] Type-check and `npm run build` both pass on the frontend
- [ ] A public route group and an authenticated route group both exist and render
- [ ] The backend's `/health` endpoint responds with a 200 over PHP's built-in server
- [ ] The scaffold is committed with a message you reviewed

## References

- Next.js — App Router docs: https://nextjs.org/docs/app
- Tailwind CSS — Installation: https://tailwindcss.com/docs/installation
- shadcn/ui — Installation: https://ui.shadcn.com/docs/installation
- Next.js — Route groups: https://nextjs.org/docs/app/building-your-application/routing/route-groups
- Slim Framework — Installation: https://www.slimframework.com/docs/v4/start/installation.html
