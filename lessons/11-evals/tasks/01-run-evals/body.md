- **Start your eval-journey** by installing `web-codegen-scorer` directly into the Bookmonkey frontend
  ```bash
  cd app/frontend
  npm install --save-dev web-codegen-scorer
  ```
---
- **Create an environment config** at `app/frontend/eval.config.mjs`, modeled on the [official React/Next.js setup](https://github.com/angular/web-codegen-scorer):
  ```js
  import { getBuiltInRatings } from 'web-codegen-scorer';

  export default {
    displayName: 'bookmonkey-react',
    clientSideFramework: 'react',
    sourceDirectory: '.',
    ratings: [...getBuiltInRatings()],
    generationSystemPrompt: './eval-system-instructions.md',
    executablePrompts: ['./eval-prompts/**/*.md'],
  };
  ```
---
- **Provide your API-Key** for Anthropic's models
  ```bash
  export ANTHROPIC_API_KEY="sk-ant-..."
  ```
---
- **Run your 1st evaluation**
  ```bash
  npx web-codegen-scorer eval --env=./eval.config.mjs
  ```
---
- *Study* the report carefully
  ```bash
  npx web-codegen-scorer report
  ```
---
- **Run more** evaluations
  1. Improve your `AGENTS.md` (repo root) to score better results
  1. Improve your eval prompts in `eval-prompts/` to score better results
  1. Add more prompts to `eval-prompts/**/*.md` to execute multiple evaluations in parallel
