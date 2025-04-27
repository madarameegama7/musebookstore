<?php require APPROOT.'/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<style>
    .delete-article-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .delete-article-header {
        background-color: #e74c3c;
        color: white;
        padding: 30px 40px;
        border-radius: 10px 10px 0 0;
        position: relative;
        overflow: hidden;
        margin-bottom: 0;
    }
    
    .delete-article-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: skewX(-25deg);
    }
    
    .delete-article-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }
    
    .delete-article-content {
        background-color: #fff;
        border-radius: 0 0 10px 10px;
        padding: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }
    
    .article-info {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .article-title {
        font-size: 1.5rem;
        margin: 0 0 15px;
        color: #333;
    }
    
    .article-meta {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: #777;
        font-size: 0.9rem;
    }
    
    .article-date {
        margin-right: 15px;
    }
    
    .delete-warning {
        background-color: #fff3f3;
        border-left: 4px solid #e74c3c;
        padding: 15px 20px;
        margin: 20px 0;
        border-radius: 0 8px 8px 0;
    }
    
    .delete-warning h4 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #e74c3c;
    }
    
    .delete-warning p {
        margin: 0;
        color: #555;
        line-height: 1.5;
    }
    
    .form-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn-delete {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-delete:hover {
        background-color: #c0392b;
    }
    
    .btn-cancel {
        background-color: #f5f5f5;
        color: #333;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-cancel:hover {
        background-color: #e0e0e0;
    }
    
    @media (max-width: 768px) {
        .form-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="delete-article-container">
    <div class="delete-article-header">
        <h1>Delete Article</h1>
    </div>
    
    <div class="delete-article-content">
        <div class="article-info">
            <h2 class="article-title"><?php echo $data['article']->title; ?></h2>
            
            <div class="article-meta">
                <span class="article-date">Created: <?php echo date('F j, Y', strtotime($data['article']->created_at)); ?></span>
            </div>
            
            <div class="article-excerpt">
                <?php echo substr(strip_tags($data['article']->content), 0, 150) . '...'; ?>
            </div>
        </div>
        
        <div class="delete-warning">
            <h4>Warning!</h4>
            <p>You are about to delete this article. This action cannot be undone. Once deleted, you will not be able to recover this article or its content.</p>
        </div>
        
        <form action="<?php echo URLROOT; ?>/child/deleteArticle/<?php echo $data['article']->article_id; ?>" method="post">
            <div class="form-buttons">
                <button type="submit" class="btn-delete">Yes, Delete This Article</button>
                <a href="<?php echo URLROOT; ?>/child/myArticles" class="btn-cancel">No, Keep This Article</a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
