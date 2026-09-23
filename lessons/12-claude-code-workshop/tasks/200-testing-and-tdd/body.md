## Overview

Use the agent to build a real safety net across the test pyramid, and practise **test-driven
development** with an agent — letting tests give it a built-in "done" signal.

## Prerequisites

- Recommended: any local browser-automation MCP tool already configured for this workshop for
  end-to-end browser flows.

## Background

Agents are strong test writers and can run tests themselves, which makes testing the most reliable
feedback loop available to them. Agents won't reliably do TDD unless you ask, so make it explicit.

## Steps

1. Pick a domain rule (for example, a borrow request can't be accepted twice). Instruct the agent
   to use **TDD**: write failing tests first (PHPUnit for the backend rule, or Vitest if the rule
   lives in the frontend), review them, then implement the minimal code to pass.
2. Before the implementation, review the tests and ask the agent to enumerate **edge cases**; add
   any it missed.
3. Ask the agent to add an **integration test** that exercises a write against an ephemeral
   database.
4. Have it add one **end-to-end test** for a critical path.
5. Have the agent wire the **quality gates** (type-check, lint, build, tests) into a single
   command it can run itself, and record it in project memory.
6. Reflect on how having a runnable test loop changed the agent's behaviour.

## Success Criteria

- [ ] A domain rule was implemented test-first, with tests reviewed before code
- [ ] An integration test exercises a real write against an ephemeral database
- [ ] One end-to-end test covers a critical path
- [ ] A single command runs all quality gates

## References

- Test pyramid (Martin Fowler): https://martinfowler.com/articles/practical-test-pyramid.html
- Vitest — Getting started: https://vitest.dev/guide/
- Playwright — Writing tests: https://playwright.dev/docs/writing-tests
