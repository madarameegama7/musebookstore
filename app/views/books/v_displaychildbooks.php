<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_id'])) {
    die("Please login");
}
?>

<div class="books-container">
    <h2><?php echo isset($data['title']) ? $data['title'] : 'All Books'; ?></h2>
    <p class="subtitle">Browse our collection of available books</p>
    
    <?php flash('post_msg'); ?>
    
    <?php if(empty($data['books'])) : ?>
        <div class="alert alert-info">No books available at the moment. Please check back later.</div>
    <?php else : ?>
        <div class="books-grid">
            <?php foreach ($data['books'] as $book): ?>
                <div class="book-card">
                <img src="<?php echo URLROOT . '/img/bookImgs/' . ($book->book_image ?? 'default.jpg'); ?>" alt="Book Image">
                    <div class="book-card-content">
                        <h3><?php echo $book->book_title; ?></h3>
                        <p><strong>By:</strong> <?php echo $book->book_author; ?></p>
                        <p><strong>Genre:</strong> <?php echo $book->book_genre; ?></p>
                        <p><strong>Condition:</strong> <?php echo $book->book_condition; ?></p>
                        <p><strong>Price:</strong> <?php echo number_format($book->book_price, 2); ?> LKR</p>
                        
                        <div class="book-controls">
                            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'child') : ?>
                                <!-- Child users go to child/viewBook -->
                                <a href="<?php echo URLROOT; ?>/child/viewBook/<?php echo $book->book_id; ?>" class="book-btn view-btn">View Details</a>
                               
                            <?php else : ?>
                                <!-- Regular users go to books/view -->
                                <a href="<?php echo URLROOT; ?>/books/view/<?php echo $book->book_id; ?>" class="book-btn view-btn">View Details</a>
                                <?php if(isset($_SESSION['user_id'])) : ?>
                                    <?php if($book->owner_id == $_SESSION['user_id']) : ?>
                                        <a href="<?php echo URLROOT; ?>/books/edit/<?php echo $book->book_id; ?>" class="book-btn request-btn">Edit</a>
                                        <a href="#" onclick="if(confirm('Are you sure you want to delete this book?')) { document.getElementById('delete-form-<?php echo $book->book_id; ?>').submit(); }" class="book-btn delete-btn">Delete</a>
                                        <form id="delete-form-<?php echo $book->book_id; ?>" action="<?php echo URLROOT; ?>/books/delete/<?php echo $book->book_id; ?>" method="post" style="display: none;"></form>
                                    <?php else : ?>
                                        <a href="<?php echo URLROOT; ?>/books/purchase/<?php echo $book->book_id; ?>" class="book-btn request-btn">Purchase</a>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <a href="<?php echo URLROOT; ?>/users/login" class="book-btn request-btn">Login to Buy</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

