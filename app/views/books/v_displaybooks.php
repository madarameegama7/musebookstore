<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_id'])) {
    die("Please login");
}
?>

<div class="articles-container">
    <h2>Books</h2>
    <?php flash('post_msg'); ?>
    <div class="articles">
        <?php foreach ($data['books'] as $book): ?>
            <div class="articles-card">
                <img src="/musebookstore/public/img/index-page.jpg">
                <h3><?php echo $book->book_title; ?></h3>
                <p>By <?php echo $book->book_author; ?></p>
                <p><?php echo $book->book_genre; ?></p>
                <?php if ($book->user_id == $_SESSION['user_id']): ?>
                    <div class="book-ctrl-button">
                        <a href="<?php echo URLROOT ?>/books/edit/<?php echo $book->book_id ?>"><button
                                class="book-ctrl-btn">Edit</button></a>
                        <a href="#"
                            onclick="if(confirm('Are you sure you want to delete this book?')) { document.getElementById('delete-form-<?php echo $book->book_id; ?>').submit(); }">
                            <button class="book-ctrl-btn">Delete</button>
                        </a>
                        <form id="delete-form-<?php echo $book->book_id; ?>"
                            action="<?php echo URLROOT; ?>/books/delete/<?php echo $book->book_id; ?>" method="post"
                            style="display: none;"></form>

                    </div>
                <?php else: ?>
                    <div class="book-ctrl-button">
                        <a href="#"><button class="book-ctrl-btn">Show Details</button></a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <br>
    <a href="#" id="showMoreBtn">Show More Articles</a>
</div>