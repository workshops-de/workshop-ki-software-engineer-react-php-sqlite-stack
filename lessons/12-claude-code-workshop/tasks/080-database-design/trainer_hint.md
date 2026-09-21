## Learning goals

- **Skills:** turning a model into a schema; running and recovering from migrations; generating
  seed data with the agent.
- **Concepts:** schema-first modelling with plain SQL; relations and uniqueness constraints;
  representing enums as documented strings in SQLite; foreign keys are opt-in per connection.
- **Takeaways:** specify precisely, verify visually, let the agent close its own loop.

## Facilitation notes

- The PDO/SQLite pitfalls listed in the task (foreign keys off by default, no native enums) were
  validated against this repo's own `app/backend` — expect at least one participant to forget
  `PRAGMA foreign_keys = ON` and be surprised an "invalid" row inserted successfully; point them
  at the Pitfalls section rather than solving it for them.
- A failed migration self-correcting is one of the best live demonstrations of the Reason → Act →
  Observe loop from Day 1 — call it out explicitly if it happens.

## Time estimate

~45 minutes.
