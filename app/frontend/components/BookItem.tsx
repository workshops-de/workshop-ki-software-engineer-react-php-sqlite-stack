import Image from 'next/image';
import type { Book } from '@/types/book';

interface BookItemProps {
  book: Book;
}

export function BookItem({ book }: BookItemProps) {
  return (
    <div className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col h-full">
      <div className="relative aspect-[3/4] overflow-hidden bg-gray-100">
        {book.cover ? (
          <Image src={book.cover} alt={book.title} fill className="object-contain" />
        ) : (
          <div className="w-full h-full flex items-center justify-center">
            <span className="text-gray-500 text-sm font-medium">No cover available</span>
          </div>
        )}
      </div>
      <div className="p-5 flex flex-col flex-grow">
        <h2 className="text-lg font-semibold text-gray-800 mb-1 line-clamp-2">{book.title}</h2>
        {book.subtitle && <p className="text-sm text-gray-600 mb-2 line-clamp-2">{book.subtitle}</p>}
        <div className="text-sm text-gray-700 mt-auto">
          <p>
            <span className="text-blue-700">{book.author}</span>
          </p>
          {book.isbn && <p className="text-xs text-gray-500 mt-2">ISBN: {book.isbn}</p>}
        </div>
      </div>
    </div>
  );
}
