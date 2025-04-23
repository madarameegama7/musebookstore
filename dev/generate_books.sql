-- Sample Books for testing
-- Insert sample books
INSERT INTO `book` (`book_title`, `book_author`, `book_genre`, `book_condition`, `book_price`, `listing_type`, `owner_id`, `book_status`, `created_at`, `book_publisher`, `book_published_year`, `book_ISBN`) VALUES
('Harry Potter and the Philosopher''s Stone', 'J.K. Rowling', 'Fantasy', 'new', 1500.00, 'sell', 5, 'available', NOW(), 'Bloomsbury', 1997, '9780747532743'),
('The Lion, the Witch and the Wardrobe', 'C.S. Lewis', 'Fantasy', 'new', 1200.00, 'sell', 5, 'available', NOW(), 'Geoffrey Bles', 1950, '9780064471046'),
('Charlotte''s Web', 'E.B. White', 'Children''s Fiction', 'used', 800.00, 'sell', 5, 'available', NOW(), 'Harper & Brothers', 1952, '9780064410939'),
('The Very Hungry Caterpillar', 'Eric Carle', 'Picture Book', 'new', 600.00, 'sell', 17, 'available', NOW(), 'World Publishing Company', 1969, '9780399226908'),
('Matilda', 'Roald Dahl', 'Children''s Fiction', 'new', 950.00, 'rent', 17, 'available', NOW(), 'Jonathan Cape', 1988, '9780141301068'),
('The Gruffalo', 'Julia Donaldson', 'Picture Book', 'used', 550.00, 'sell', 7, 'available', NOW(), 'Macmillan', 1999, '9780333710937'),
('Wonder', 'R.J. Palacio', 'Children''s Fiction', 'new', 1100.00, 'sell', 5, 'available', NOW(), 'Knopf', 2012, '9780375869020'),
('Percy Jackson and the Lightning Thief', 'Rick Riordan', 'Fantasy', 'new', 1300.00, 'rent', 17, 'available', NOW(), 'Disney Hyperion', 2005, '9780786838653'),
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 'used', 1400.00, 'sell', 20, 'available', NOW(), 'George Allen & Unwin', 1937, '9780261102217'),
('Anne of Green Gables', 'L.M. Montgomery', 'Classic', 'new', 950.00, 'sell', 20, 'available', NOW(), 'L.C. Page & Co.', 1908, '9780553213133'),
('The Secret Garden', 'Frances Hodgson Burnett', 'Classic', 'used', 850.00, 'rent', 7, 'available', NOW(), 'Frederick A. Stokes', 1911, '9780064401883'),
('A Wrinkle in Time', 'Madeleine L''Engle', 'Science Fiction', 'new', 1050.00, 'sell', 5, 'available', NOW(), 'Farrar, Straus and Giroux', 1962, '9780312367541'),
('The Diary of a Young Girl', 'Anne Frank', 'Biography', 'new', 900.00, 'sell', 17, 'available', NOW(), 'Contact Publishing', 1947, '9780553296983'),
('The Tale of Peter Rabbit', 'Beatrix Potter', 'Picture Book', 'new', 500.00, 'sell', 20, 'available', NOW(), 'Frederick Warne & Co.', 1902, '9780723247708'),
('The BFG', 'Roald Dahl', 'Children''s Fiction', 'new', 950.00, 'rent', 7, 'available', NOW(), 'Jonathan Cape', 1982, '9780142410387');