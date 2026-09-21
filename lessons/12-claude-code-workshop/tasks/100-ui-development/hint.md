<details>
<summary>💡 Hint 1: Resist special-casing the second feature</summary>

The point is that the shape repeats — differences should be minor (e.g. one extra field).

</details>

<details>
<summary>💡 Hint 2: Two sides, two schemas, kept in sync deliberately</summary>

The frontend's Zod schema and the backend's PHP validation can't literally share one definition
across the network boundary — keep them side by side and deliberately in sync, and remember the
PHP side is the one that actually protects you.

</details>

<details>
<summary>💡 Hint 3: Build one screen at a time</summary>

Verify each screen before moving to the next rather than building all four at once.

</details>
