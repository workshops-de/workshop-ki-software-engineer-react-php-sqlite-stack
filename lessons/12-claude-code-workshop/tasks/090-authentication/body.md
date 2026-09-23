## Overview

Add real authentication — registration, login, logout, sessions, and a route guard — and practise
the most important habit for security-sensitive work: **reviewing the agent's output yourself**.
You delegate the implementation, but you own the security properties of what ships.

## Prerequisites

- None external. No extra package install is needed: everything here is PHP's built-in
  `session_*` functions plus `password_hash()`/`password_verify()`, already available in the
  `app/backend` scaffold from task 060 — rely on the linked docs below.

## Background

In a split frontend/backend stack, authentication has two halves that must agree. The **PHP
backend** hashes passwords, validates credentials, and — on success — starts a **native PHP
session** (`session_start()`), storing the user's id server-side in `$_SESSION`. PHP sets the
session cookie for you; there is no token to sign, no secret to manage, and nothing to add to
`composer.json`. The **Next.js frontend** just needs to send that cookie on every request that
needs it (`credentials: 'include'`) and guard protected routes based on whether the backend says
the caller is signed in. Security-sensitive code is exactly where "you push it, you own it"
matters most.

## Steps

1. Ask the agent — in planning mode first — to implement, on the **backend**: a `/register`
   endpoint (hashes the password with `password_hash()`), a `/login` endpoint (verifies with
   `password_verify()`, then `session_start()` + `session_regenerate_id(true)` + stores the
   user id in `$_SESSION`), a `/logout` endpoint (`session_destroy()`), and a `/me` endpoint that
   returns the current user or a 401. Any endpoint behind auth must check `$_SESSION['user_id']`
   and reject with 401 if it's missing.
2. Configure the session cookie explicitly rather than trusting PHP's defaults: httpOnly, a
   `SameSite` setting appropriate for two `localhost` ports, and `session.use_strict_mode`.
   Add the matching CORS headers on the backend (`Access-Control-Allow-Origin` set to the
   frontend's exact origin — never `*` when credentials are involved — plus
   `Access-Control-Allow-Credentials: true`).
3. On the **frontend**, ask the agent to send `credentials: 'include'` on every request to the
   backend, call `/me` to determine signed-in state, and add a guard that redirects signed-out
   users away from the protected area.
4. **Review the diff line by line.** Confirm passwords are hashed with `password_hash()` (never
   stored or logged in plaintext), the session id is regenerated on login (prevents session
   fixation), and the cookie is httpOnly with a sensible `SameSite` setting.
5. Verify the guard actually blocks every protected page when logged out, redirecting to sign-in.
6. Ask the agent to **explain its choices** for the session and cookie configuration, then
   challenge at least one of them and adjust if warranted.
7. Test end to end: register, log out, log back in, and confirm protected pages redirect when
   signed out.
8. As a final pass, ask the agent to outline potential weaknesses in the implementation and triage
   what it finds.

## Success Criteria

- [ ] Register, login, and logout work end to end; the session persists across reloads
- [ ] Passwords are stored only as `password_hash()` output and never logged or returned to the
      client
- [ ] The session id is regenerated on login (`session_regenerate_id(true)`), not reused from
      before authentication
- [ ] The session cookie is httpOnly with an explicit `SameSite` setting; CORS allows credentials
      only from the frontend's exact origin, never `*`
- [ ] The guard redirects every protected page to sign-in when signed out
- [ ] `npm run build` passes on the frontend; the backend's protected endpoints return 401 without
      a valid session — and nothing here required adding a new Composer or npm package

## Pitfalls (this stack)

- **No package needed.** If the agent reaches for a JWT library (`firebase/php-jwt` or similar),
  push back — native PHP sessions cover this without adding a dependency or a signing secret to
  manage. (If your real project later needs stateless, horizontally-scaled auth across multiple
  PHP servers without shared session storage, that's when a signed token earns its complexity —
  not here.)
- The frontend runs on a different **port** than the backend in local dev (`:3000` vs. `:8080`).
  Cookies are scoped by host, not port, so this is still "same site" for `SameSite=Lax` — but the
  browser will still drop the cookie silently if CORS doesn't send
  `Access-Control-Allow-Credentials: true` with a specific (non-wildcard) allowed origin, or if
  the frontend's `fetch` calls forget `credentials: 'include'`.
- PHP's default session save path/garbage collection settings are usually fine for a workshop-
  scale app — don't let the agent over-engineer a custom session store.
- A `redirect()` inside a Next.js Server Component/Route Handler works by **throwing** — don't
  swallow it in `try/catch`.

## References

- PHP — `password_hash()` / `password_verify()`: https://www.php.net/manual/en/function.password-hash.php
- PHP — Session handling (`session_start`, `session_regenerate_id`): https://www.php.net/manual/en/book.session.php
- PHP — `session_set_cookie_params()`: https://www.php.net/manual/en/function.session-set-cookie-params.php
- MDN — `SameSite` cookies: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite
- OWASP — Session management cheat sheet: https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html
