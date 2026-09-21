## Learning goals

- **Skills:** reviewing security-sensitive agent output; reading diffs critically; challenging the
  agent's decisions.
- **Concepts:** password hashing; native PHP sessions; session fixation and why regenerating the
  id on login matters; route-level guards; CORS with credentials.
- **Takeaways:** trust but verify; the commit has your name on it; the simplest mechanism that
  meets the requirement (a native session, not a hand-rolled token scheme) is usually right.

## Facilitation notes

- This is a good moment to slow the room down — resist the urge to let people rubber-stamp the
  diff. Ask at least one person to read their diff aloud.
- If someone "vibe-codes" this task (accepts everything without reading), use it as a teaching
  moment about "you push it, you own it" rather than a failure.
- **Rewritten for offline delivery:** the original version used a JWT (`firebase/php-jwt`, a
  Composer package) for the session token. That needed one network call to Packagist to install.
  This version uses PHP's built-in `session_*` functions instead — zero additional packages,
  zero setup-time network dependency, and arguably the more correct choice for a single-server
  app like this one anyway.
- Common issue: CORS credentials silently failing because the frontend forgot
  `credentials: 'include'`, or the backend sent `Access-Control-Allow-Origin: *` (which browsers
  reject outright when credentials are involved).
- Common issue on recent Next.js: forgetting to `await cookies()`/`headers()`.

## Time estimate

~45 minutes; this closes out the "Modeling & Building the Skeleton" morning.
