# Build a PHP Migration MCP Tool

You already have a working MCP server that can generate React components. Now extend it with a tool that runs automated PHP migrations — so the AI can execute the full update process for you.

## Your Goal

Add a `run_migration` tool to your MCP server that executes an automated PHP code migration using [Rector](https://getrector.com/) — the PHP equivalent of Angular's `ng update` schematics.

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

Add a new `registerTool` call in `tools/php-mcp/index.ts`:

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
    },
  },
  async ({ phpVersion }) => {
    // Your implementation here
  }
);
```

### 3. Implement the migration command

Inside the handler, build and execute the Rector command:

```ts
const cmd = `vendor/bin/rector process --set php${phpVersion.replace('.', '')} --dry-run`;
```

- Run the command with `exec(cmd, { cwd: backendRoot })`
- Return a success message including `stdout` on success
- Return a clear error message including `stderr` on failure
- Once the dry run looks good, re-run without `--dry-run` to apply the changes

### 4. Build and reload

```bash
npm run build.php-mcp
```

Reload Cursor via **Cmd+Shift+P → Developer: Reload Window**.

### 5. Test it

Ask the AI in Cursor chat:

```
Migrate the backend to PHP 8.3
```

The AI should call your `run_migration` tool and show the output.

## Success Criteria

- [ ] Rector is installed in `app/backend`
- [ ] The `run_migration` tool is registered in `index.ts`
- [ ] The tool accepts a `phpVersion` parameter
- [ ] The tool executes the correct `rector process` command
- [ ] Errors are caught and returned as readable messages
- [ ] The server builds and Cursor recognizes the new tool
