## Learning goals

- **Skills:** plan-then-execute; verifying each step; delegating scaffolding safely.
- **Concepts:** App Router project layout; route groups for public vs. authenticated areas;
  a two-process stack (Next.js frontend + PHP backend) vs. a Next.js monolith.
- **Takeaways:** review the plan, run the app, commit what you own.

## Facilitation notes

- Known pitfall: dangling nav links to pages not built yet will 404 until their tasks — reassure
  participants this is expected.
- Participants coming from a Next.js-only background may expect the backend to also be Next.js
  (API routes/Server Actions) — this workshop deliberately keeps it split (separate PHP process)
  to mirror the rest of this course. Flag this early.
- **This workshop runs fully offline/air-gapped at this customer.** If the agent proposes
  anything that needs an external account or network call at generation or run time (a UI-kit CLI
  that fetches component source from a registry, a deployment step, telemetry) — redirect it to a
  local-only alternative before it gets stuck retrying a request that will never succeed.
- This is the first "real" building task after the Foundations morning — energy is usually high;
  keep the scope disciplined so later tasks have room to build on a clean base.

## Time estimate

~45 minutes including install/setup time.
