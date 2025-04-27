<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="articles-container">
    <h2>Books</h2>

    <!-- Show flash message if available -->
    <?php flash('post_msg'); ?>

    <?php if (empty($data['books'])): ?>
        <p>No books to display</p>
    <?php else: ?>
        <div class="articles">
            <?php foreach ($data['books'] as $book): ?>
                <div class="articles-card">
                <img src="<?php echo URLROOT . '/img/bookImgs/' . ($book->book_image ?? 'default.jpg'); ?>" alt="Book Image">
                    <h3><?php echo $book->book_title; ?></h3>
                    <p>By <?php echo $book->book_author; ?></p>
                    <p><?php echo $book->book_genre; ?></p>
                    <div class="book-ctrl-button">
                        <a href="<?php echo URLROOT; ?>/books/book_preview/<?php echo $book->book_id; ?>"><button class="book-ctrl-btn">Show Details</button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <br>
</div>
