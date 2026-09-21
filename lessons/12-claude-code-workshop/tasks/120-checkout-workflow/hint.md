<details>
<summary>💡 Hint 1: Decide legal transitions before coding</summary>

There are only two states and two transitions here — write them down as a tiny diagram if it
helps, then reject anything that isn't one of them.

</details>

<details>
<summary>💡 Hint 2: Authorization is the subtle part</summary>

Make sure only the person who checked a book out can return it — test this explicitly with a
second account, not just the happy path.

</details>

<details>
<summary>💡 Hint 3: Order your checks deliberately</summary>

Check the current state *and* who's asking before writing anything — decide which check should
fail first and why.

</details>
