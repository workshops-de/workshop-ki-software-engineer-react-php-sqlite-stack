import { render, screen } from '@testing-library/react';
import { describe, expect, it } from 'vitest';
import { BookItem } from './BookItem';
import type { Book } from '@/types/book';

const book: Book = {
  id: '1',
  isbn: '9781491950357',
  title: 'Learning React',
  author: 'Alex Banks & Eve Porcello',
  userId: 1,
};

describe('BookItem', () => {
  it('renders the title and author', () => {
    render(<BookItem book={book} />);

    expect(screen.getByText('Learning React')).toBeInTheDocument();
    expect(screen.getByText('Alex Banks & Eve Porcello')).toBeInTheDocument();
  });
});
