<?php require APPROOT.'/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<style>
    .favorites-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .favorites-header {
        background-color: #673AB7;
        color: white;
        padding: 30px 40px;
        border-radius: 10px 10px 0 0;
        position: relative;
        overflow: hidden;
    }
    
    .favorites-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: skewX(-25deg);
    }
    
    .favorites-header h1 {
        margin: 0;
        font-size: 2.5rem;
        font-weight: 600;
    }
    
    .favorites-content {
        background: white;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .favorites-empty {
        text-align: center;
        padding: 40px 0;
        color: #666;
    }
    
    .favorites-empty h3 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
    }
    
    .favorites-empty p {
        font-size: 1.1rem;
        margin-bottom: 25px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .browse-btn {
        display: inline-block;
        background-color: #673AB7;
        color: white;
        padding: 12px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .browse-btn:hover {
        background-color: #5E35B1;
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Books grid styling */
    .books {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: flex-start;
    }
    
    .book-card {
        width: calc(33.333% - 20px);
        margin-bottom: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    .book-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .book-card-content {
        padding: 15px;
    }
    
    .book-card h3 {
        margin: 0 0 10px;
        font-size: 18px;
        color: #333;
    }
    
    .book-card p {
        margin: 5px 0;
        color: #666;
        font-size: 14px;
    }
    
    .book-controls {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }
    
    .book-btn {
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    
    .view-btn {
        background-color: #336699;
        color: white;
    }
    
    .view-btn:hover {
        background-color: #245180;
    }
    
    .remove-btn {
        background-color: #f44336;
        color: white;
    }
    
    .remove-btn:hover {
        background-color: #d32f2f;
    }
    
    @media (max-width: 992px) {
        .book-card {
            width: calc(50% - 20px);
        }
    }
    
    @media (max-width: 576px) {
        .book-card {
            width: 100%;
        }
    }
</style>

<div class="favorites-container">
    <?php flash('favorite_success'); ?>
    <?php flash('favorite_error'); ?>
    
    <div class="favorites-header">
        <h1><?php echo $data['page_title']; ?></h1>
    </div>
    
    <div class="favorites-content">
        <?php if(empty($data['books'])) : ?>
            <div class="favorites-empty">
                <h3>You don't have any favorite books yet</h3>
                <p>Explore our collection and add books to your favorites to build your reading wishlist!</p>
                <a href="<?php echo URLROOT; ?>/pages/index" class="browse-btn">Browse Books</a>
            </div>
        <?php else : ?>
            <div class="books">
                <?php foreach($data['books'] as $book) : ?>
                    <div class="book-card">
                        <img src="<?php echo URLROOT; ?>/public/img/index-page.jpg" alt="<?php echo $book->book_title; ?>">
                        <div class="book-card-content">
                            <h3><?php echo $book->book_title; ?></h3>
                            <p><strong>By:</strong> <?php echo $book->book_author; ?></p>
                            <p><strong>Genre:</strong> <?php echo $book->book_genre; ?></p>
                            <p><strong>Condition:</strong> <?php echo $book->book_condition; ?></p>
                            <p><strong>Price:</strong> <?php echo number_format($book->book_price, 2); ?> LKR</p>
                            <div class="book-controls">
                                <a href="<?php echo URLROOT; ?>/child/viewBook/<?php echo $book->book_id; ?>" class="book-btn view-btn">View Details</a>
                                <a href="<?php echo URLROOT; ?>/child/removeFromFavorites/<?php echo $book->book_id; ?>" class="book-btn remove-btn">Remove</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
