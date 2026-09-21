import type { NextConfig } from 'next';
import { fileURLToPath } from 'node:url';

const nextConfig: NextConfig = {
  images: {
    // Book covers are served by the PHP backend itself (app/backend/public/covers) and
    // the URL host (e.g. "localhost:8080") is only reachable from the browser, not from
    // inside the frontend container's own network namespace. Next's built-in image
    // optimization runs server-side, so it would try (and fail) to fetch the image itself.
    // Skip optimization and let the browser load covers directly instead.
    unoptimized: true,
  },
  // Silences the "multiple lockfiles" warning: the repo root has its own
  // package-lock.json for the Slidev/slides tooling, unrelated to this app.
  outputFileTracingRoot: fileURLToPath(new URL('.', import.meta.url)),
};

export default nextConfig;
