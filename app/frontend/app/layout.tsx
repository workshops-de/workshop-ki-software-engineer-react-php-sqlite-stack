import type { Metadata } from 'next';
import './globals.css';

export const metadata: Metadata = {
  title: 'Bookmonkey',
  description: 'A book collection built during the KI Software Engineer workshop',
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
