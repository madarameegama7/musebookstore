<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<style>
    .book-detail-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .book-detail-header {
        background-color: #336699;
        color: white;
        padding: 30px 40px;
        border-radius: 10px 10px 0 0;
        position: relative;
        overflow: hidden;
    }
    
    .book-detail-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: skewX(-25deg);
    }
    
    .book-detail-header h1 {
        margin: 0;
        font-size: 2.5rem;
        font-weight: 600;
    }
    
    .book-detail-content {
        background: white;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .book-image-container {
        flex: 0 0 300px;
        position: relative;
    }
    
    .book-image {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .book-price-badge {
        position: absolute;
        top: -15px;
        right: -15px;
        background: #ff9900;
        color: white;
        font-size: 1.2rem;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 50px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
    }
    
    .book-info {
        flex: 1;
        min-width: 300px;
    }
    
    .book-info h2 {
        color: #336699;
        margin-top: 0;
        border-bottom: 2px solid #f1f1f1;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    
    .book-info-item {
        margin-bottom: 15px;
        font-size: 1.1rem;
    }
    
    .book-info-label {
        font-weight: 600;
        color: #444;
        display: inline-block;
        width: 140px;
    }
    
    .book-info-value {
        color: #666;
    }
    
    .condition-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
    }
    
    .condition-new {
        background-color: #e6f7ff;
        color: #0077cc;
        border: 1px solid #b3e0ff;
    }
    
    .condition-used {
        background-color: #fff7e6;
        color: #cc7700;
        border: 1px solid #ffe0b3;
    }
    
    .action-buttons {
        margin-top: 30px;
        display: flex;
        gap: 15px;
    }
    
    .btn-request {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    .btn-request:hover {
        background-color: #388E3C;
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .btn-pending {
        background-color: #FFC107;
        color: #333;
        cursor: default;
    }
    
    .btn-pending:hover {
        background-color: #FFC107;
        transform: none;
        box-shadow: none;
    }
    
    .btn-approved {
        background-color: #4CAF50;
        cursor: default;
    }
    
    .btn-approved:hover {
        background-color: #4CAF50;
        transform: none;
        box-shadow: none;
    }
    
    .btn-denied {
        background-color: #F44336;
        cursor: default;
    }
    
    .btn-denied:hover {
        background-color: #F44336;
        transform: none;
        box-shadow: none;
    }
    
    .btn-back {
        background-color: #f1f1f1;
        color: #333;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    .btn-back:hover {
        background-color: #ddd;
    }
    
    @media (max-width: 768px) {
        .book-detail-content {
            flex-direction: column;
        }
        
        .book-image-container {
            margin: 0 auto;
        }
    }
</style>

<div class="book-detail-container">
    <?php flash('request_success'); ?>
    <?php flash('request_error'); ?>
    
    <div class="book-detail-header">
        <h1><?= $data['book']->book_title ?></h1>
    </div>
    
    <div class="book-detail-content">
        <div class="book-image-container">
            <!-- Using a placeholder image - replace with actual book image when available -->
            <img src="<?= URLROOT ?>/public/img/index-page.jpg" alt="<?= $data['book']->book_title ?>" class="book-image">
            <div class="book-price-badge"><?= number_format($data['book']->book_price, 2) ?> LKR</div>
        </div>
        
        <div class="book-info">
            <h2>Book Details</h2>
            
            <div class="book-info-item">
                <span class="book-info-label">Author:</span>
                <span class="book-info-value"><?= $data['book']->book_author ?></span>
            </div>
            
            <div class="book-info-item">
                <span class="book-info-label">Genre:</span>
                <span class="book-info-value"><?= $data['book']->book_genre ?></span>
            </div>
            
            <div class="book-info-item">
                <span class="book-info-label">Condition:</span>
                <span class="condition-badge <?= $data['book']->book_condition == 'new' ? 'condition-new' : 'condition-used' ?>">
                    <?= $data['book']->book_condition ?>
                </span>
            </div>
            
            <div class="book-info-item">
                <span class="book-info-label">Publisher:</span>
                <span class="book-info-value"><?= $data['book']->book_publisher ?></span>
            </div>
            
            <div class="book-info-item">
                <span class="book-info-label">Published Year:</span>
                <span class="book-info-value"><?= $data['book']->book_published_year ?></span>
            </div>
            
            <div class="book-info-item">
                <span class="book-info-label">ISBN:</span>
                <span class="book-info-value"><?= $data['book']->book_ISBN ?></span>
            </div>
            
            <div class="book-info-item">
                <span class="book-info-label">Listing Type:</span>
                <span class="book-info-value"><?= ucfirst($data['book']->listing_type) ?></span>
            </div>
            
            <div class="action-buttons">
                <?php if(!$data['request']) : ?>
                    <!-- No request exists, show Request button -->
                    <a href="<?= URLROOT ?>/child/requestBook/<?= $data['book']->book_id ?>">
                        <button class="btn-request">Request This Book</button>
                    </a>
                <?php elseif($data['request']->status == 'pending') : ?>
                    <!-- Request is pending -->
                    <button class="btn-request btn-pending" disabled>
                        <i class="fas fa-clock mr-2"></i> Requested - Pending
                    </button>
                <?php elseif($data['request']->status == 'approved') : ?>
                    <!-- Request is approved -->
                    <button class="btn-request btn-approved" disabled>
                        <i class="fas fa-check-circle mr-2"></i> Approved by Parent
                    </button>
                <?php elseif($data['request']->status == 'denied') : ?>
                    <!-- Request is denied -->
                    <button class="btn-request btn-denied" disabled>
                        <i class="fas fa-times-circle mr-2"></i> Request Denied
                    </button>
                <?php endif; ?>
                
                <a href="<?= URLROOT ?>/child/childHome">
                    <button class="btn-back">Back to Books</button>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php';?>
