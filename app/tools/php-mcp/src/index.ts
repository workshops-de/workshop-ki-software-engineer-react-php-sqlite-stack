import { McpServer } from '@modelcontextprotocol/sdk/server/mcp.js';
import { StdioServerTransport } from '@modelcontextprotocol/sdk/server/stdio.js';
import { exec as execCallback } from 'node:child_process';
import { unlink, writeFile } from 'node:fs/promises';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import { promisify } from 'node:util';
import { z } from 'zod';

const exec = promisify(execCallback);

// Rector has no "--set" CLI flag (unlike `ng update`) — rule sets are chosen via a config
// file. We only allow the exact PHP versions Rector ships a SetList constant for, and map
// each one explicitly to that constant name to avoid ever interpolating raw user input
// into generated PHP code.
const PHP_VERSION_TO_RECTOR_SET: Record<string, string> = {
  '7.0': 'PHP_70',
  '7.1': 'PHP_71',
  '7.2': 'PHP_72',
  '7.3': 'PHP_73',
  '7.4': 'PHP_74',
  '8.0': 'PHP_80',
  '8.1': 'PHP_81',
  '8.2': 'PHP_82',
  '8.3': 'PHP_83',
  '8.4': 'PHP_84',
};

// app/tools/php-mcp/src/index.ts -> app/
const appRoot = join(dirname(fileURLToPath(import.meta.url)), '..', '..', '..');
const frontendRoot = join(appRoot, 'frontend');
const backendRoot = join(appRoot, 'backend');

const server = new McpServer({
  name: 'php-mcp',
  version: '1.0.0',
});

// Security: every value that ends up in a shell command string (via `exec`) must be
// validated first. These patterns reject path traversal ("../"), shell metacharacters,
// and anything that isn't the exact shape we expect — see the lesson's "Security
// Checklist" slide for why this matters.
const COMPONENT_NAME_PATTERN = /^[A-Za-z][A-Za-z0-9]*$/;
const COMPONENT_PATH_PATTERN = /^[A-Za-z0-9/_-]+$/;

function errorResult(message: string) {
  return { content: [{ type: 'text' as const, text: `❌ ${message}` }], isError: true as const };
}

server.registerTool(
  'generate_component',
  {
    title: 'Generate React Component',
    description: 'Creates a new React component using the project generator script',
    inputSchema: {
      name: z.string().describe('Component name, e.g. BookDetail'),
      path: z.string().optional().describe('Target path in app/frontend/components'),
      withTest: z.boolean().optional().describe('Also generate a Vitest test file'),
    },
  },
  async ({ name, path, withTest }) => {
    if (!COMPONENT_NAME_PATTERN.test(name)) {
      return errorResult(`Invalid component name "${name}". Use PascalCase letters and digits only.`);
    }
    if (path !== undefined && (!COMPONENT_PATH_PATTERN.test(path) || path.includes('..'))) {
      return errorResult(`Invalid path "${path}". Use letters, digits, "/", "_", "-" only — no "..".`);
    }

    const target = path ? `${path}/${name}` : name;
    const flags = withTest ? '--with-test' : '';
    const cmd = `npm run generate:component -- ${target} ${flags}`.trim();

    try {
      const { stdout } = await exec(cmd, { cwd: frontendRoot });
      return { content: [{ type: 'text' as const, text: `✅ Generated:\n${stdout}` }] };
    } catch (e) {
      const msg = e instanceof Error ? e.message : String(e);
      return errorResult(msg);
    }
  }
);

server.registerTool(
  'run_migration',
  {
    title: 'Run PHP Migration',
    description:
      'Executes an automated PHP code migration using Rector. ' +
      'Use this when the user wants to upgrade PHP language features or apply a Rector rule set.',
    inputSchema: {
      phpVersion: z.string().describe("Target PHP version, e.g. '8.3'"),
      dryRun: z.boolean().optional().describe('Preview changes without writing them (default: true)'),
    },
  },
  async ({ phpVersion, dryRun = true }) => {
    const setConstant = PHP_VERSION_TO_RECTOR_SET[phpVersion];
    if (!setConstant) {
      const supported = Object.keys(PHP_VERSION_TO_RECTOR_SET).join(', ');
      return errorResult(`Unsupported PHP version "${phpVersion}". Supported: ${supported}.`);
    }

    // Rector configures its target rule set via a config file, not a CLI flag. Generate a
    // throwaway config for this run and pass it with --config.
    const configPath = join(backendRoot, `rector.runtime.${Date.now()}.php`);
    const configContents = `<?php

declare(strict_types=1);

use Rector\\Config\\RectorConfig;
use Rector\\Set\\ValueObject\\SetList;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/public'])
    ->withSets([SetList::${setConstant}]);
`;

    const dryRunFlag = dryRun ? ' --dry-run' : '';
    const cmd = `vendor/bin/rector process --config=${configPath}${dryRunFlag} --no-progress-bar`;

    try {
      await writeFile(configPath, configContents, 'utf-8');
      const { stdout } = await exec(cmd, { cwd: backendRoot });
      return { content: [{ type: 'text' as const, text: `✅ Migration${dryRun ? ' preview' : ''}:\n${stdout}` }] };
    } catch (e) {
      const msg = e instanceof Error ? e.message : String(e);
      return errorResult(msg);
    } finally {
      await unlink(configPath).catch(() => {});
    }
  }
);

const transport = new StdioServerTransport();
await server.connect(transport);
