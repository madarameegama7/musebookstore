<?php
/**
 * Edit Comment View
 * Allows child users to edit their existing comments on books
 */
require APPROOT.'/views/inc/header.php';
?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<style>
    .edit-comment-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .edit-comment-header {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .edit-comment-header h2 {
        color: #336699;
        margin-bottom: 5px;
    }
    
    .edit-comment-form textarea {
        width: 100%;
        min-height: 150px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        font-family: inherit;
        resize: vertical;
    }
    
    .edit-comment-form textarea:focus {
        outline: none;
        border-color: #336699;
        box-shadow: 0 0 5px rgba(51, 102, 153, 0.3);
    }
    
    .edit-comment-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
    
    .btn-update {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-update:hover {
        background-color: #388E3C;
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background-color: #f5f5f5;
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .btn-cancel:hover {
        background-color: #eee;
    }
</style>

<div class="edit-comment-container">
    <div class="edit-comment-header">
        <h2>Edit Your Comment</h2>
    </div>
    
    <?php flash('comment_error'); ?>
    
    <div class="edit-comment-form">
        <form action="<?php echo URLROOT; ?>/child/editComment/<?php echo $data['comment_id']; ?>/<?php echo $data['book_id']; ?>" method="post">
            <textarea name="comment" placeholder="Edit your comment..."><?php echo $data['comment']; ?></textarea>
            
            <div class="edit-comment-buttons">
                <a href="<?php echo URLROOT; ?>/child/viewBook/<?php echo $data['book_id']; ?>" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-update">Update Comment</button>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
