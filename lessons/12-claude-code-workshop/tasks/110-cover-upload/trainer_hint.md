## Learning goals

- **Skills:** integrating a client-only browser API into a server-first app; stating constraints
  up front; validating on both sides of a network boundary.
- **Concepts:** client vs. server components; the browser `File`/`FileReader` APIs; why client
  validation is UX, not security.
- **Takeaways:** lead with hard constraints; isolate browser-only interactivity into focused
  client components; local storage is enough for a workshop-scale app.

## Facilitation notes

- Consider a live demo: run the task once WITHOUT stating the constraint (let the agent try an
  SSR-friendly approach or reach for a cloud upload SDK and stall) vs. WITH the constraint stated,
  side by side, to make the lesson vivid.
- This task was rewritten for a fully offline/air-gapped delivery: the original version used an
  interactive map with external tiles (Leaflet + OpenStreetMap), which cannot work without
  outbound network access. Everything here — the file read, the preview, the storage — stays on
  `localhost` and the local filesystem.
- Watch for participants who reach for a third-party upload widget/SDK out of habit; redirect them
  to the native `File`/`FileReader` APIs.

## Time estimate

~45 minutes.
