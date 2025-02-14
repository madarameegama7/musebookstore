CREATE TABLE users(
    users_id INT PRIMARY KEY AUTO_INCREMENT,
    users_name VARCHAR(100) UNIQUE NOT NULL,
    users_email VARCHAR(100) UNIQUE NOT NULL,
    users_password VARCHAR(255) NOT NULL,
    users_NIC VARCHAR(20) NOT NULL,
    users_role ENUM('parent','child','ambassador','admin') NOT NULL,
    parent_id INT,
    tokens INT DEFAULT 0,
    users_phone VARCHAR(20),
    users_address VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES users(users_id)
    );

CREATE TABLE book( 
book_id INT PRIMARY KEY AUTO_INCREMENT, 
book_title VARCHAR(255) NOT NULL, 
book_author VARCHAR(255) NOT NULL, 
book_genre VARCHAR(255) NOT NULL, 
book_condition ENUM('new','used') NOT NULL, 
book_price DECIMAL(10,2), 
listing_type ENUM('sell','swap') NOT NULL, 
owner_id INT NOT NULL, 
book_status ENUM('available','sold','swapped') DEFAULT 'available', 
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
FOREIGN KEY (owner_id) REFERENCES user(user_id) 
);

CREATE TABLE transaction(
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    book_id INT NOT NULL,
    buyer_id INT NOT NULL,
    seller_id INT NOT NULL,
    type ENUM('sell','swap') NOT NULL,
    status ENUM('pending','approved','declined','completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (book_id) REFERENCES book(book_id),
    FOREIGN KEY (buyer_id) REFERENCES user(user_id),
    FOREIGN KEY (seller_id) REFERENCES user(user_id)
    );

CREATE TABLE notification( 
notification_id INT PRIMARY KEY AUTO_INCREMENT, 
user_id INT NOT NULL, 
message TEXT NOT NULL, 
is_read BOOLEAN DEFAULT 0, 
notification_status BOOLEAN, 
transaction_id INT, 
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
FOREIGN KEY (user_id) REFERENCES user(user_id), 
FOREIGN KEY (transaction_id) REFERENCES transaction(transaction_id) 
);
CREATE TABLE transaction(
token_id INT PRIMARY KEY AUTO_INCREMENT,
token_count INT DEFAULT 0,
user_id INT NOT NULL,
FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE payment(
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_transaction_id INT NOT NULL,
    payment_status ENUM('pending','completed','failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (user_id) REFERENCES user(user_id)
    );