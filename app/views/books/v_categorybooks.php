<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="articles-container">
    <h2>Books in "<?php echo htmlspecialchars($data['category']); ?>"</h2>

    <?php if (empty($data['books'])): ?>
        <p>No books found in this category.</p>
    <?php else: ?>
        <div class="articles">
            <?php foreach ($data['books'] as $book): ?>
                <div class="articles-card">
                    <img src="/musebookstore/public/img/index-page.jpg">
                    <h3><?php echo $book->book_title; ?></h3>
                    <p>By <?php echo $book->book_author; ?></p>
                    <p><?php echo $book->book_genre; ?></p>
                    <div class="book-ctrl-button">
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'child'): ?>
                            <a href="<?= URLROOT ?>/child/viewBook/<?= $book->book_id ?>"><button class="book-ctrl-btn">Show Details</button></a>
                        <?php else: ?>
                            <a href="#"><button class="book-ctrl-btn">Show Details</button></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
