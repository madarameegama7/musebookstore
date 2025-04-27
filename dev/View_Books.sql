CREATE VIEW v_books AS
select 
book.book_id as book_id,
user.user_id as book_owner_id,
user.user_name as book_owner_name,
book.book_title as book_title,
book.book_author as book_author,
book.book_genre as book_genre,
book.book_price as book_price,
book.listing_type as listing_type,
book.book_condition as book_condition,
book.book_publisher as book_publisher,
book.book_published_year as book_published_year,
book.book_ISBN as book_ISBN
FROM book INNER JOIN user
ON book.owner_id = user.user_id
ORDER by book.created_at;

