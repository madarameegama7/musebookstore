<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="book-preview-container">
    <div class="book-cover">
    <img src="<?php echo URLROOT . '/img/bookImgs/' . ($data['books']->book_image ?? 'default.jpg'); ?>" alt="Book Image">
    </div>
    <div class="book-details">
        <p><strong><?php echo strtoupper($data['books']->book_genre); ?></strong></p>
        <h2><?php echo $data['books']->book_title; ?></h2>
        <p>By <strong><?php echo $data['books']->book_author; ?></strong></p>
        <br>
        <?php if ($data['books']->listing_type === 'sell'): ?>
            <button class="cta-button">Buy Book</button>

        <?php elseif ($data['books']->listing_type === 'swap'): ?>
            <button class="cta-button">Swap Book</button>
        <?php endif; ?>

    </div>
</div>

<div class="about-section">
    <h3>About Book</h3>
    <p>Book Condition <strong><?php echo $data['books']->book_condition; ?></strong></p>
    <p>Book Publisher <strong><?php echo $data['books']->book_publisher; ?></strong></p>
    <p>Published Year <strong><?php echo $data['books']->book_published_year; ?></strong></p>
</div>