import type { Book } from '@/types/book';

const API_URL = process.env.NEXT_PUBLIC_API_URL ?? 'http://localhost:8080';

export async function getBooks(pageSize: number = 10, searchTerm?: string): Promise<Book[]> {
  const params = new URLSearchParams({ _limit: pageSize.toString() });

  if (searchTerm) {
    // Search in title and author fields
    params.set('q', searchTerm);
  }

  const response = await fetch(`${API_URL}/books?${params.toString()}`);

  if (!response.ok) {
    throw new Error(`Failed to fetch books: ${response.status}`);
  }

  return response.json();
}

export async function getBook(id: string): Promise<Book> {
  const response = await fetch(`${API_URL}/books/${id}`);

  if (!response.ok) {
    throw new Error(`Failed to fetch book ${id}: ${response.status}`);
  }

  return response.json();
}
