<details>
<summary>💡 Hint 1: No secret to manage is a feature, not a gap</summary>

If the agent starts drafting an env var for a "JWT secret," stop it — native sessions don't need
one. The cookie flags (httpOnly, SameSite) and session-id regeneration are what deserve your
review time instead.

</details>

<details>
<summary>💡 Hint 2: One guard beats scattered checks</summary>

A guard enforced once for the whole protected area is easier to reason about than checks
scattered across pages.

</details>

<details>
<summary>💡 Hint 3: "Explain why you chose this"</summary>

A powerful prompt for security review — if the agent hard-codes anything sensitive, that's a
finding worth fixing.

</details>
