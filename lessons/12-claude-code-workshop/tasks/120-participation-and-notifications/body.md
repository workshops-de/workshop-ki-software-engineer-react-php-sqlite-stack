## Overview

Implement the heart of the domain: people request to borrow a book, the owner accepts or rejects,
and each transition notifies the right person. You will learn to **encode a state machine
explicitly** so the agent doesn't invent ad-hoc statuses, and to attach cross-cutting side-effects
(notifications) cleanly to the write path.

## Prerequisites

- Recommended: `react-best-practices`
- Optional: `agent-browser` to drive the flow end-to-end with two accounts.

## Background

A borrow request moves from _pending_ to _accepted_ or _rejected_; modelling those states and
transitions explicitly keeps the implementation honest. Every transition is a write that should
follow the same validated, authorized path as other mutations (a PHP endpoint) — and additionally
create a notification row for the right user.

## Steps

1. State the **transitions** to the agent: requesting to borrow creates a pending borrow request
   and notifies the book's owner; accept and reject move it to the corresponding state and notify
   the requester. Confirm the agent restates them correctly.
2. Implement request/cancel and owner accept/reject as PHP endpoints that validate, **authorize**
   (only the owner may decide), persist, and insert the right notification row.
3. Build the requester-facing UI (request/cancel with feedback) and the owner-facing requests
   view.
4. Add a grouped "my borrow requests" view splitting active loans, awaiting approval, and
   declined.
5. Verify with two seeded accounts: one requests, the other (the owner) accepts; confirm the
   notification reaches the right person and views update.
6. Optionally extend: notify a bookstore's owner when a new book is listed as available there.

## Success Criteria

- [ ] Request/cancel and owner accept/reject work and enforce authorization
- [ ] Each transition creates a notification for the correct person
- [ ] Invalid transitions are rejected; a book can't have two simultaneous pending requests
- [ ] "My borrow requests" groups active / awaiting / declined correctly; `npm run build` passes

## References

- State machine concept: https://en.wikipedia.org/wiki/Finite-state_machine
- Slim Framework — Request/Response: https://www.slimframework.com/docs/v4/objects/request.html
- SQLite — Transactions (for multi-row writes like "update request + insert notification"):
  https://sqlite.org/lang_transaction.html
