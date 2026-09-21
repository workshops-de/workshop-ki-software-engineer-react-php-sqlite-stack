## Overview

Add a cover-image upload with a live preview, and learn to **state a hard technical constraint up
front** so the agent doesn't head down a dead end. Reading a file the user picked and rendering a
preview is inherently a **browser-only** operation in an otherwise server-first app — telling the
agent that constraint first is context-engineering applied to implementation.

## Background

The upload widget uses the browser's native `File` and `FileReader` APIs (no third-party upload
service, no image-hosting SaaS): the user picks a file, the browser reads it, and a `<canvas>` or
an `<img>` with an object URL shows the preview — all before anything is sent anywhere. Because
this touches `window`, `File`, and `FileReader`, it cannot be server-rendered; it must live in a
client component. The final image is stored **locally**: sent to the PHP backend as
base64 (or `multipart/form-data`) and written to a file on disk next to the SQLite database, then
referenced by path — no cloud storage involved.

## Steps

1. Before implementing, tell the agent the **constraint** clearly: reading the picked file and
   rendering a preview is client-only and cannot be server-rendered. Ask it to plan within that
   constraint.
2. Implement the picker and preview: selecting a file shows an immediate preview without a round
   trip to the backend.
3. Add basic **client-side guardrails**: reject files above a size limit and anything that isn't
   an image type, with a clear error message.
4. Wire up the **upload**: submitting the form sends the image to a PHP endpoint that validates
   it again (never trust the client's checks alone), stores it on local disk, and returns a path
   the frontend can render.
5. Integrate the upload into the book create/edit screens without breaking the rest of the app.
6. Verify interactively: pick a file, see the instant preview, save, reload the page, and confirm
   the saved cover still renders from the local path.
7. Reflect on how stating the constraint first changed the agent's approach.

## Success Criteria

- [ ] Picking a file shows an instant client-side preview, no network round trip required
- [ ] Oversized files or non-image types are rejected client-side with a clear message
- [ ] The backend re-validates the upload (size, type) before writing it to disk
- [ ] The saved cover renders correctly after a full page reload; `npm run build` passes
- [ ] Nothing in this feature calls an external service — everything stays on `localhost` and the
      local filesystem

## References

- MDN — Using files from web applications (`File`, `FileReader`): https://developer.mozilla.org/en-US/docs/Web/API/File_API/Using_files_from_web_applications
- MDN — `URL.createObjectURL()`: https://developer.mozilla.org/en-US/docs/Web/API/URL/createObjectURL_static
- Next.js — Lazy loading / dynamic import (if you split it into its own chunk): https://nextjs.org/docs/app/building-your-application/optimizing/lazy-loading
- PHP — Handling file uploads: https://www.php.net/manual/en/features.file-upload.php
