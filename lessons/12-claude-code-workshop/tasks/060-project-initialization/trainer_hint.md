## Learning goals

- **Skills:** plan-then-execute; verifying each step; delegating scaffolding safely.
- **Concepts:** App Router project layout; route groups for public vs. authenticated areas;
  a two-process stack (Next.js frontend + PHP backend) vs. a Next.js monolith.
- **Takeaways:** review the plan, run the app, commit what you own.

## Facilitation notes

- Known pitfall: dangling nav links to pages not built yet (map, books, bookstores) will 404 until
  their tasks — reassure participants this is expected.
- The shadcn CLI's interactive prompts are a common stall point; watch for participants who think
  the process hung.
- Participants coming from a Next.js-only background may expect the backend to also be Next.js
  (API routes/Server Actions) — this workshop deliberately keeps it split (separate PHP process)
  to mirror the rest of this course. Flag this early so nobody scaffolds a Prisma schema by
  reflex.
- This is the first "real" building task after the Foundations morning — energy is usually high;
  keep the scope disciplined so later tasks have room to build on a clean base.

## Time estimate

~45 minutes including install/setup time.
