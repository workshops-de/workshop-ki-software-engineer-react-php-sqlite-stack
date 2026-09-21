#!/usr/bin/env node
// Simple React component generator, used as the CLI wrapped by the
// "Build a PHP Migration MCP Tool" lesson's sibling tool: generate_component.
//
// Usage:
//   npm run generate:component -- BookDetail
//   npm run generate:component -- books/BookDetail --with-test --with-story

import { mkdirSync, writeFileSync, existsSync } from 'node:fs';
import { dirname, join, basename } from 'node:path';

const args = process.argv.slice(2);
const target = args.find((arg) => !arg.startsWith('--'));
const withTest = args.includes('--with-test');
const withStory = args.includes('--with-story');

if (!target) {
  console.error('Usage: npm run generate:component -- <Name> [--with-test] [--with-story]');
  process.exit(1);
}

const componentsRoot = join(process.cwd(), 'components');
const name = basename(target);
const targetDir = join(componentsRoot, dirname(target) === '.' ? '' : dirname(target));
const filePath = join(targetDir, `${name}.tsx`);

if (existsSync(filePath)) {
  console.error(`Component already exists: ${filePath}`);
  process.exit(1);
}

mkdirSync(targetDir, { recursive: true });

writeFileSync(
  filePath,
  `interface ${name}Props {}\n\nexport function ${name}({}: ${name}Props) {\n  return <div>${name}</div>;\n}\n`
);
console.log(`✅ Created ${filePath}`);

if (withTest) {
  const testPath = join(targetDir, `${name}.test.tsx`);
  writeFileSync(
    testPath,
    `import { render, screen } from '@testing-library/react';\nimport { describe, expect, it } from 'vitest';\nimport { ${name} } from './${name}';\n\ndescribe('${name}', () => {\n  it('renders', () => {\n    render(<${name} />);\n    expect(screen.getByText('${name}')).toBeInTheDocument();\n  });\n});\n`
  );
  console.log(`✅ Created ${testPath}`);
}

if (withStory) {
  const storyPath = join(targetDir, `${name}.stories.tsx`);
  writeFileSync(
    storyPath,
    `import type { Meta, StoryObj } from '@storybook/react';\nimport { ${name} } from './${name}';\n\nconst meta: Meta<typeof ${name}> = {\n  title: 'Components/${name}',\n  component: ${name},\n};\n\nexport default meta;\n\nexport const Default: StoryObj<typeof ${name}> = {};\n`
  );
  console.log(`✅ Created ${storyPath}`);
}
