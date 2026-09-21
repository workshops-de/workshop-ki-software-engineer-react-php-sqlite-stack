'use client';

import { useEffect, useRef, useState } from 'react';
import { getBooks } from '@/lib/api';
import type { Book } from '@/types/book';
import { BookItem } from './BookItem';

interface BookListProps {
  pageSize?: number;
}

export function BookList({ pageSize = 10 }: BookListProps) {
  const [books, setBooks] = useState<Book[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState('');
  const searchTimeout = useRef<ReturnType<typeof setTimeout> | undefined>(undefined);

  const loadBooks = async (search?: string) => {
    setLoading(true);
    try {
      const result = await getBooks(pageSize, search);
      setBooks(result);
    } catch (error) {
      console.error('Error fetching books:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadBooks();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  const onSearchChange = (value: string) => {
    setSearchTerm(value);
    clearTimeout(searchTimeout.current);
    searchTimeout.current = setTimeout(() => {
      loadBooks(value);
    }, 300);
  };

  const clearSearch = () => {
    setSearchTerm('');
    loadBooks();
  };

  return (
    <div className="container mx-auto px-4 py-12 max-w-7xl">
      <h1 className="text-3xl font-bold mb-10 text-blue-700 border-b pb-4 border-gray-200">Book Collection</h1>

      <div className="mb-6">
        <div className="flex items-center border-b-2 border-gray-300 py-2">
          <input
            type="text"
            value={searchTerm}
            onChange={(event) => onSearchChange(event.target.value)}
            placeholder="Search for books..."
            className="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
          />
          {searchTerm && (
            <button onClick={clearSearch} className="flex-shrink-0 text-gray-500 hover:text-gray-700">
              ✕
            </button>
          )}
        </div>
      </div>

      {loading ? (
        <div className="flex justify-center items-center py-20">
          <div className="animate-pulse flex flex-col items-center">
            <div className="h-16 w-16 rounded-full border-4 border-t-blue-700 border-r-blue-700 border-b-gray-200 border-l-gray-200 animate-spin" />
            <p className="mt-4 text-gray-600">Loading books...</p>
          </div>
        </div>
      ) : (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-8">
          {books.map((book) => (
            <BookItem key={book.id} book={book} />
          ))}

          {books.length === 0 && (
            <div className="col-span-full flex flex-col items-center justify-center py-16 text-center bg-gray-50 rounded-xl">
              <p className="text-xl font-medium text-gray-600 mb-2">
                {searchTerm ? 'No books match your search' : 'No books available'}
              </p>
              <p className="text-gray-500">
                {searchTerm ? 'Try different search terms or clear the search' : 'Check back later'}
              </p>
              {searchTerm && (
                <button
                  onClick={clearSearch}
                  className="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200"
                >
                  Clear Search
                </button>
              )}
            </div>
          )}
        </div>
      )}
    </div>
  );
}
