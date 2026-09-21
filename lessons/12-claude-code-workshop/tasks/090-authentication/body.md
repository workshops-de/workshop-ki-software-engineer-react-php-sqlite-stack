## Overview

Add real authentication — registration, login, logout, sessions, and a route guard — and practise
the most important habit for security-sensitive work: **reviewing the agent's output yourself**.
You delegate the implementation, but you own the security properties of what ships.

## Prerequisites

- Recommended skills: `react-best-practices`
- No dedicated skill covers PHP password hashing/JWT — rely on the linked docs below.

## Background

In a split frontend/backend stack, authentication has two halves that must agree: the **PHP
backend** hashes passwords, validates credentials, and issues a signed token; the **Next.js
frontend** stores that token, sends it on every request that needs it, and guards protected
routes. Security-sensitive code is exactly where "you push it, you own it" matters most.

## Steps

1. Ask the agent — in planning mode first — to implement, on the **backend**: a `/register`
   endpoint (hashes the password), a `/login` endpoint (verifies the password, issues a signed
   token), and a `/logout` endpoint. Any endpoint behind auth must reject requests without a valid
   token.
2. On the **frontend**, ask it to store the token (an httpOnly cookie set via a small Next.js Route
   Handler that proxies to the backend is the safest option — a token readable by client
   JavaScript is not), attach it to authenticated requests, and add a guard that redirects signed-
   out users away from the protected area.
3. **Review the diff line by line.** Confirm passwords are hashed with `password_hash()` (never
   stored or logged in plaintext), the token's signing secret comes from an environment variable
   on the backend, and the cookie is httpOnly with a sensible same-site setting.
4. Verify the guard actually blocks every protected page when logged out, redirecting to sign-in.
5. Ask the agent to **explain its choices** for the token and cookie, then challenge at least one
   of them and adjust if warranted.
6. Test end to end: register, log out, log back in, and confirm protected pages redirect when
   signed out.
7. As a final pass, ask the agent to outline potential weaknesses in the implementation and triage
   what it finds.

## Success Criteria

- [ ] Register, login, and logout work end to end; the session persists across reloads
- [ ] Passwords are stored only as `password_hash()` output and never logged or returned to the
      client
- [ ] The token's signing secret is env-sourced on the backend, not hard-coded
- [ ] The session cookie is httpOnly (secure in production) and the guard redirects every
      protected page to sign-in when signed out
- [ ] `npm run build` passes on the frontend; the backend's protected endpoints reject requests
      without a valid token

## Pitfalls (this stack)

- Never store the token in `localStorage`/a JS-readable cookie for anything you'd call "session" —
  any XSS becomes full account takeover. Use an httpOnly cookie.
- The frontend runs on a different origin/port than the backend in local dev (`:3000` vs. `:8080`)
  — CORS and cookie `SameSite`/`Secure` settings need to actually work together, not just "work on
  localhost by accident."
- If you use PHP's native sessions instead of a signed token, remember `session.cookie_httponly`
  and `session.cookie_samesite` are configuration, not defaults you can assume.
- A `redirect()` inside a Next.js Server Component/Route Handler works by **throwing** — don't
  swallow it in `try/catch`.

## References

- PHP — `password_hash()` / `password_verify()`: https://www.php.net/manual/en/function.password-hash.php
- PHP-JWT (firebase/php-jwt) — signing/verifying tokens: https://github.com/firebase/php-jwt
- Next.js — Route Handlers: https://nextjs.org/docs/app/building-your-application/routing/route-handlers-and-middleware
- OWASP — Authentication cheat sheet: https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html
