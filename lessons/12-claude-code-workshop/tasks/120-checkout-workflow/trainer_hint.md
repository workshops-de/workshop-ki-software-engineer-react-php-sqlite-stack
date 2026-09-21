## Learning goals

- **Skills:** implementing a small state machine; attaching a side-effect to a write; enforcing
  authorization on a transition.
- **Concepts:** finite states and transitions; a cross-cutting concern (the activity log) kept
  entirely local; ordering validation vs. authorization checks.
- **Takeaways:** model states explicitly; route every transition through the validated write path;
  a "notification" doesn't need an external service to teach the lesson.

## Facilitation notes

- This task was simplified for a fully offline/air-gapped delivery: the original version modelled
  a two-party join/accept/reject workflow with cross-user notifications. This version keeps the
  same core lesson (explicit states, authorization on transitions, a side-effect on every write)
  with a single entity and no external delivery mechanism.
- This closes out "Building Bookmonkey" — a good checkpoint to confirm everyone has a working
  vertical slice (list/detail/create/edit plus this small workflow) before the next morning shifts
  focus to Claude Code's own building blocks.
- Two-account testing is the step people skip — actively check for it during the room walk.

## Time estimate

~45 minutes.
