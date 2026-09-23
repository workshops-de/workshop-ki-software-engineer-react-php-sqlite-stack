## Overview

Implement a small but real state machine: a signed-in user **checks out** a book, and later
**returns** it — and every transition is recorded in a simple, local **activity log** rather than
an external notification service. You will learn to **encode a state machine explicitly** so the
agent doesn't invent ad-hoc statuses, and to attach a cross-cutting side-effect (the log entry)
cleanly to the write path.

## Prerequisites

- None external.

## Background

A book moves from _available_ to _checked out_ and back; modelling those two states and the
transitions between them explicitly keeps the implementation honest. Every transition is a write
that should follow the same validated path as other mutations (a PHP endpoint) — and additionally
insert a row into a local `activity_log` table (`{book_id, user_id, action, created_at}`). There is
no email, push notification, or external service involved: the "notification" is simply a list
the affected user can see in the app.

## Steps

1. State the **transitions** to the agent: checking out an available book marks it `checked_out`
   and records who did it; returning it marks it `available` again. Confirm the agent restates
   them correctly.
2. Implement checkout and return as PHP endpoints that validate the current state (you can't check
   out an already-checked-out book), **authorize** (only the person who checked a book out may
   return it), persist the new state, and insert an activity-log row.
3. Build the UI: a checkout/return button on the book detail page with clear feedback, and a
   simple "recent activity" list showing the last few log entries.
4. Verify with two seeded accounts: one checks a book out, confirm the other account cannot return
   it, then confirm the original account can.
5. Reflect: what would break if the state check and the authorization check happened in the wrong
   order?

## Success Criteria

- [ ] Checkout and return work and enforce the correct state transition
- [ ] Only the user who checked a book out can return it — verified with a second account
- [ ] Every transition inserts one activity-log row; the log is visible in the UI
- [ ] Attempting an invalid transition (e.g. checking out an already-checked-out book) is rejected
      with a clear error, not a 500

## References

- State machine concept: https://en.wikipedia.org/wiki/Finite-state_machine
- Slim Framework — Request/Response: https://www.slimframework.com/docs/v4/objects/request.html
- SQLite — Transactions (for multi-row writes like "update status + insert log row"):
  https://sqlite.org/lang_transaction.html
