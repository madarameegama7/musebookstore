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
    
    .btn-favorite-add {
        background-color: #03A9F4;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    .btn-favorite-add:hover {
        background-color: #039BE5;
    }
    
    .btn-favorite-remove {
        background-color: #F44336;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    .btn-favorite-remove:hover {
        background-color: #d32f2f;
    }
    
    @media (max-width: 768px) {
        .book-detail-content {
            flex-direction: column;
        }
        
        .book-image-container {
            margin: 0 auto;
        }
    }
    
    /* Comments section styling */
    .comments-section {
        margin-top: 40px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .comments-header {
        border-bottom: 2px solid #f1f1f1;
        padding-bottom: 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .comments-header h2 {
        color: #336699;
        margin: 0;
    }
    
    .comment-count {
        background: #f1f1f1;
        color: #666;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
    }
    
    .comment-form {
        margin-bottom: 30px;
    }
    
    .comment-form textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
        min-height: 100px;
        margin-bottom: 15px;
    }
    
    .comment-form button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .comment-form button:hover {
        background-color: #388E3C;
    }
    
    .comments-list {
        margin-top: 20px;
    }
    
    .comment-item {
        padding: 15px;
        border-bottom: 1px solid #f1f1f1;
        margin-bottom: 15px;
    }
    
    .comment-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    
    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .comment-user {
        font-weight: 600;
        color: #336699;
    }
    
    .comment-date {
        color: #999;
        font-size: 0.9rem;
    }
    
    .comment-content {
        color: #444;
        line-height: 1.5;
    }
    
    .comment-actions {
        margin-top: 10px;
        text-align: right;
    }
    
    .btn-edit-comment {
        background-color: #03A9F4;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 0.8rem;
        transition: all 0.2s;
    }
    
    .btn-edit-comment:hover {
        background-color: #039BE5;
    }
    
    .btn-delete-comment {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 0.8rem;
        transition: all 0.2s;
    }
    
    .btn-delete-comment:hover {
        background-color: #d32f2f;
    }
    
    .no-comments {
        text-align: center;
        color: #999;
        padding: 20px 0;
        font-style: italic;
    }
</style>

<div class="book-detail-container">
    <?php flash('request_success'); ?>
    <?php flash('request_error'); ?>
    <?php flash('favorite_success'); ?>
    <?php flash('favorite_error'); ?>
    
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
                
                <?php if($data['is_favorited']) : ?>
                    <!-- Book is in favorites, show Remove from Favorites button -->
                    <a href="<?= URLROOT ?>/child/removeFromFavorites/<?= $data['book']->book_id ?>">
                        <button class="btn-favorite-remove">Remove from Favorites</button>
                    </a>
                <?php else : ?>
                    <!-- Book is not in favorites, show Add to Favorites button -->
                    <a href="<?= URLROOT ?>/child/addToFavorites/<?= $data['book']->book_id ?>">
                        <button class="btn-favorite-add">Add to Favorites</button>
                    </a>
                <?php endif; ?>
                
                <a href="<?= URLROOT ?>/pages/index">
                    <button class="btn-back">Back to Books</button>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Comments Section -->
<div class="comments-section">
    <?php flash('comment_success'); ?>
    <?php flash('comment_error'); ?>
    
    <div class="comments-header">
        <h2>Book Comments</h2>
        <span class="comment-count"><?= count($data['comments']) ?> comments</span>
    </div>
    
    <!-- Comment form -->
    <div class="comment-form">
        <form action="<?php echo URLROOT; ?>/child/addComment/<?php echo $data['book']->book_id; ?>" method="post">
            <textarea name="comment" placeholder="Share your thoughts about this book..."></textarea>
            <button type="submit">Post Comment</button>
        </form>
    </div>
    
    <!-- Comments list -->
    <div class="comments-list">
        <?php if(empty($data['comments'])) : ?>
            <div class="no-comments">No comments yet. Be the first to comment!</div>
        <?php else : ?>
            <?php foreach($data['comments'] as $comment) : ?>
                <div class="comment-item">
                    <div class="comment-header">
                        <span class="comment-user"><?php echo $comment->user_name; ?></span>
                        <span class="comment-date"><?php echo date('F j, Y g:i a', strtotime($comment->created_at)); ?></span>
                    </div>
                    <div class="comment-content">
                        <?php echo $comment->comment; ?>
                    </div>
                    <?php if($comment->user_id == $_SESSION['user_id']) : ?>
                        <div class="comment-actions">
                            <a href="<?php echo URLROOT; ?>/child/editComment/<?php echo $comment->id; ?>/<?php echo $data['book']->book_id; ?>">
                                <button class="btn-edit-comment">Edit</button>
                            </a>
                            <a href="<?php echo URLROOT; ?>/child/deleteComment/<?php echo $comment->id; ?>/<?php echo $data['book']->book_id; ?>" 
                               onclick="return confirm('Are you sure you want to delete this comment?');">
                                <button class="btn-delete-comment">Delete</button>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php';?>
