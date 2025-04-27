<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_id'])) {
    die("Please login");
}
?>

<div class="choosebook-container" style="max-width: 1000px; margin: 40px auto;">
    <h2>Select a Book to Offer in Swap</h2>
    <form action="<?php echo URLROOT; ?>/swaps/confirmSwap/<?php echo $data['bookToSwapWith']; ?>" method="post">
        <div class="book-cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
            <?php if (!empty($data['userBooks'])): ?>
                <?php foreach ($data['userBooks'] as $book): ?>
                    <div class="book-card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center;">
                        <label style="cursor: pointer;">
                            <input type="radio" name="offer_book_id" value="<?php echo $book->book_id; ?>" required style="margin-bottom: 10px;">
                            <div class="cover" style="height: 250px; overflow: hidden; margin-bottom: 10px;">
                                <img src="<?php echo URLROOT; ?>/img/book_covers/<?php echo $book->book_cover; ?>" alt="<?php echo htmlspecialchars($book->book_title); ?>" style="max-width: 100%; max-height: 100%;"> 
                            </div>
                            <h4 style="font-size: 1.1rem; margin: 5px 0;"><?php echo htmlspecialchars($book->book_title); ?></h4>
                            <p style="font-size: 0.9rem; color: #555;">By <?php echo htmlspecialchars($book->book_author); ?></p>
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You have no books available for swapping.</p>
            <?php endif; ?>
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 1rem;">Confirm Swap Request</button>
        </div>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
