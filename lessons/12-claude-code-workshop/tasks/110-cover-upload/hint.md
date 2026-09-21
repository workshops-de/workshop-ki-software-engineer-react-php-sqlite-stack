<details>
<summary>💡 Hint 1: Restate the constraint if needed</summary>

If the agent starts down a server-rendered path for the preview (or reaches for a cloud upload
widget/SDK), restate the client-only, local-only constraint — better early than after a broken
build or a call that will never reach the network in this environment.

</details>

<details>
<summary>💡 Hint 2: Keep the picker encapsulated</summary>

Keep the file picker and preview in their own client component; the rest of the page stays
server-first.

</details>

<details>
<summary>💡 Hint 3: Don't trust the client's validation</summary>

The size/type check in the browser is for user experience. The PHP endpoint must check again —
that's the check that actually protects you.

</details>
