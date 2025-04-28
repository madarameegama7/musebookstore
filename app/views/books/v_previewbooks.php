<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<style>
    .book-owner-tag {
        background-color: green;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        margin-top: 10px;
    }
    .custom-message {
        background-color: #f4f4f4;
        color:rgb(230, 163, 55);
        padding: 15px;
        margin-bottom: 20px;
        margin-left: 200px;
        margin-right: 200px;
        border-radius: 5px;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
    }
</style>

<!-- Custom message above the book preview container -->
<div class="custom-message">
    <p>If you wish to buy book you can contact book owner and exchange books physically</p>
    <p>Or else If you wish to swap book you can send a swap request to owner and you can swap your books with theirs</p>
</div>

<div class="book-preview-container">
    <div class="book-cover">
        <img src="<?php echo URLROOT . '/img/bookImgs/' . ($data['books']->book_image ?? 'default.jpg'); ?>" alt="Book Image">
    </div>
    <div class="book-details">
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['books']->owner_id): ?>
            <span class="book-owner-tag">Owned by You</span>
            <br><br>
        <?php endif; ?>
        <p><strong><?php echo strtoupper($data['books']->book_genre); ?></strong></p>
        <h2><?php echo $data['books']->book_title; ?></h2>
        <p>By <strong><?php echo $data['books']->book_author; ?></strong></p>
        <br>

        <!-- Show the Buy Book button if the listing type is 'sell' -->
        <?php if ($data['books']->listing_type === 'sell' && (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $data['books']->owner_id)): ?>
            <button class="cta-button">Buy Book</button>
            <br><br>
            <!-- Display owner name only for buy option -->
            <p>Book Owner: <strong><?php echo $data['owner']->book_owner; ?></strong></p>
            <p>Contact Number: <strong><?php echo $data['owner']->contact_number; ?></strong></p>
            <p>City: <strong><?php echo $data['owner']->city; ?></strong></p>
        <?php endif; ?>

        <!-- Only show the Swap Book button if the listing type is 'swap' -->
        <?php if ($data['books']->listing_type === 'swap' && (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $data['books']->owner_id)): ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($data['transactions']) && is_object($data['transactions']) && $data['transactions']->status == 'pending'): ?>
                    <button class="cta-button" disabled>Request Pending</button>
                <?php else: ?>
                    <a href="<?= URLROOT . '/books/swapbook/' . $data['books']->book_id ?>" class="cta-button">Swap Book</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= URLROOT . '/users/login'; ?>" class="cta-button">Swap Book</a>
            <?php endif; ?>
        <?php endif; ?>

        <div class="about-section">
            <h3>About Book</h3>
            <p>Book Condition <strong><?php echo $data['books']->book_condition; ?></strong></p>
            <p>Book Publisher <strong><?php echo $data['books']->book_publisher; ?></strong></p>
            <p>Published Year <strong><?php echo $data['books']->book_published_year; ?></strong></p>
        </div>
    </div>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>
