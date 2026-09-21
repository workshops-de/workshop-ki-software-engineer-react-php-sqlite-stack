<details>
<summary>💡 Hint 1: Tool handler skeleton</summary>

Your handler should follow the same pattern as `generate_component`:

```ts
async ({ phpVersion }) => {
  const set = `php${phpVersion.replace('.', '')}`;
  const cmd = `vendor/bin/rector process --set ${set} --dry-run`;
  try {
    const { stdout } = await exec(cmd, { cwd: backendRoot });
    return { content: [{ type: 'text', text: `✅ Migration preview:\n${stdout}` }] };
  } catch (e) {
    const msg = e instanceof Error ? e.message : String(e);
    return { content: [{ type: 'text', text: `❌ Migration failed: ${msg}` }] };
  }
};
```

</details>

<details>
<summary>💡 Hint 2: Rector rule sets</summary>

Rector ships with version-based rule sets such as `php80`, `php81`, `php82`, `php83`. You configure the base
set in `rector.php`:

```php
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/src'])
    ->withSets([SetList::PHP_83]);
```

`--dry-run` shows a diff without writing changes — always preview before applying.

</details>

<details>
<summary>💡 Hint 3: Cursor doesn't see the new tool</summary>

After rebuilding (`npm run build.php-mcp`), you must reload Cursor's window for it to re-read `mcp.json` and reconnect to the server.

Use **Cmd+Shift+P → Developer: Reload Window**.

</details>
