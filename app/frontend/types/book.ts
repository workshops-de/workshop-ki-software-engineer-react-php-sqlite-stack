export interface Book {
  id: string;
  isbn: string;
  title: string;
  subtitle?: string | null;
  author: string;
  publisher?: string | null;
  numPages?: number | null;
  price?: string | null;
  cover?: string | null;
  abstract?: string | null;
  userId: number;
}
