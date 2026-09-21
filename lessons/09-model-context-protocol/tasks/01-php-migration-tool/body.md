# Build a PHP Migration MCP Tool

You already have a working MCP server (`app/tools/php-mcp`) that can generate React components. Now extend it with a tool that runs automated PHP migrations — so the AI can execute the full update process for you.

## Your Goal

Add a `run_migration` tool to your MCP server that executes an automated PHP code migration using [Rector](https://getrector.org/) — the closest PHP equivalent of Angular's `ng update` schematics (it rewrites code to match a target PHP version's idioms).

The AI should be able to respond to prompts like:

```
Migrate the backend to PHP 8.3
```

## Steps

### 1. Install Rector in the backend

```bash
cd app/backend
composer require --dev rector/rector
```

### 2. Register the tool

Add a new `registerTool` call in `app/tools/php-mcp/src/index.ts`:

```ts
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
    // Your implementation here
  }
);
```

### 3. Implement the migration command

Unlike `ng update`, Rector has **no `--set` CLI flag** — the target rule set is chosen via a
config file (`-c`/`--config`). Generate a small throwaway config for the requested PHP version,
run Rector against it, then delete it again:

```ts
const configPath = join(backendRoot, `rector.runtime.${Date.now()}.php`);
const configContents = `<?php
use Rector\\Config\\RectorConfig;
use Rector\\Set\\ValueObject\\SetList;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/public'])
    ->withSets([SetList::PHP_83]); // map phpVersion -> the matching constant
`;
const cmd = `vendor/bin/rector process --config=${configPath}${dryRun ? ' --dry-run' : ''}`;
```

- Only allow a fixed set of known PHP versions (`7.0`–`8.4`) — map each one explicitly to its
  Rector `SetList::PHP_XY` constant. Never interpolate the raw `phpVersion` string into the
  generated PHP file or the shell command.
- Run the command with `exec(cmd, { cwd: backendRoot })`
- Return a success message including `stdout` on success
- Return a clear error message including `stderr` on failure
- Delete the throwaway config file again, even if the command fails (`finally`)

### 4. Build and reload

```bash
cd app/tools/php-mcp
npm run build
```

Reload Cursor via **Cmd+Shift+P → Developer: Reload Window**.

### 5. Test it

Ask the AI in Cursor chat:

```
Migrate the backend to PHP 8.3
```

The AI should call your `run_migration` tool and show the Rector diff.

## Success Criteria

- [ ] Rector is installed in `app/backend`
- [ ] The `run_migration` tool is registered in `app/tools/php-mcp/src/index.ts`
- [ ] The tool accepts `phpVersion` and only allows known versions (7.0–8.4)
- [ ] The tool generates a temporary Rector config, runs it, and cleans it up afterwards
- [ ] Errors are caught and returned as readable messages
- [ ] The server builds and Cursor recognizes the new tool
