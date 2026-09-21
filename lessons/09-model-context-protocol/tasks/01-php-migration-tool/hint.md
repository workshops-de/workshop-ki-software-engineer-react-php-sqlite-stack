<details>
<summary>💡 Hint 1: Tool handler skeleton</summary>

Your handler should follow the same pattern as `generate_component`, but write a config file first:

```ts
async ({ phpVersion, dryRun = true }) => {
  const setConstant = PHP_VERSION_TO_RECTOR_SET[phpVersion]; // e.g. 'PHP_83'
  if (!setConstant) {
    return { content: [{ type: 'text', text: `❌ Unsupported PHP version "${phpVersion}"` }], isError: true };
  }

  const configPath = join(backendRoot, `rector.runtime.${Date.now()}.php`);
  try {
    await writeFile(configPath, buildRectorConfig(setConstant), 'utf-8');
    const cmd = `vendor/bin/rector process --config=${configPath}${dryRun ? ' --dry-run' : ''}`;
    const { stdout } = await exec(cmd, { cwd: backendRoot });
    return { content: [{ type: 'text', text: `✅ Migration:\n${stdout}` }] };
  } catch (e) {
    const msg = e instanceof Error ? e.message : String(e);
    return { content: [{ type: 'text', text: `❌ Migration failed: ${msg}` }], isError: true };
  } finally {
    await unlink(configPath).catch(() => {});
  }
};
```

</details>

<details>
<summary>💡 Hint 2: Why not just pass "--set" like the Angular example?</summary>

Run `vendor/bin/rector process --help` — there is no `--set` option. Rector always reads its
rule sets from a config file (default `rector.php`, override with `-c`/`--config`). That's why
the tool writes a small PHP config file per request instead of building a CLI flag.

</details>

<details>
<summary>💡 Hint 3: Validate before you generate PHP code</summary>

Map only a fixed, known list of PHP versions to their `SetList` constant name:

```ts
const PHP_VERSION_TO_RECTOR_SET: Record<string, string> = {
  '8.1': 'PHP_81',
  '8.2': 'PHP_82',
  '8.3': 'PHP_83',
  '8.4': 'PHP_84',
};
```

Never interpolate the raw `phpVersion` argument directly into the generated config or the
shell command — an attacker-controlled string could otherwise inject arbitrary PHP or shell
code.

</details>

<details>
<summary>💡 Hint 4: Cursor doesn't see the new tool</summary>

After rebuilding (`npm run build` inside `app/tools/php-mcp`), you must reload Cursor's window
for it to re-read `mcp.json` and reconnect to the server.

Use **Cmd+Shift+P → Developer: Reload Window**.

</details>
