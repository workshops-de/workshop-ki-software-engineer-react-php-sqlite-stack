import type { NextConfig } from 'next';
import { fileURLToPath } from 'node:url';

const nextConfig: NextConfig = {
  images: {
    remotePatterns: [{ protocol: 'https', hostname: 'covers.openlibrary.org' }],
  },
  // Silences the "multiple lockfiles" warning: the repo root has its own
  // package-lock.json for the Slidev/slides tooling, unrelated to this app.
  outputFileTracingRoot: fileURLToPath(new URL('.', import.meta.url)),
};

export default nextConfig;
