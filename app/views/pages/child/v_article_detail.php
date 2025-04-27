<?php require APPROOT.'/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<style>
    .article-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .article-header {
        margin-bottom: 40px;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        color: #666;
        text-decoration: none;
        margin-bottom: 20px;
        transition: color 0.2s;
    }
    
    .back-link:hover {
        color: #E91E63;
    }
    
    .back-link i {
        margin-right: 5px;
    }
    
    .article-title {
        font-size: 2.5rem;
        margin: 0 0 20px;
        color: #333;
        line-height: 1.2;
    }
    
    .article-meta {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }
    
    .article-author {
        font-size: 1.1rem;
        color: #555;
        margin-right: 20px;
        display: flex;
        align-items: center;
    }
    
    .article-author i {
        margin-right: 5px;
        color: #E91E63;
    }
    
    .article-date {
        font-size: 0.95rem;
        color: #777;
        display: flex;
        align-items: center;
    }
    
    .article-date i {
        margin-right: 5px;
        color: #888;
    }
    
    .article-featured-image {
        width: 100%;
        border-radius: 10px;
        max-height: 400px;
        object-fit: cover;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .article-content {
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        line-height: 1.7;
        color: #444;
        font-size: 1.1rem;
    }
    
    .article-content p {
        margin-bottom: 20px;
    }
    
    .article-content h2 {
        margin-top: 30px;
        margin-bottom: 15px;
        color: #333;
    }
    
    .article-content h3 {
        margin-top: 25px;
        margin-bottom: 15px;
        color: #444;
    }
    
    .article-content ul,
    .article-content ol {
        margin-bottom: 20px;
        padding-left: 25px;
    }
    
    .article-content li {
        margin-bottom: 10px;
    }
    
    .article-content img {
        max-width: 100%;
        border-radius: 8px;
        margin: 20px 0;
    }
    
    .article-actions {
        margin-top: 40px;
        display: flex;
        gap: 15px;
    }
    
    .action-btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .action-btn i {
        margin-right: 8px;
    }
    
    .edit-btn {
        background-color: #3498db;
        color: white;
    }
    
    .edit-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }
    
    .delete-btn {
        background-color: #e74c3c;
        color: white;
    }
    
    .delete-btn:hover {
        background-color: #c0392b;
        transform: translateY(-2px);
    }
    
    .back-to-articles {
        background-color: #f5f5f5;
        color: #333;
    }
    
    .back-to-articles:hover {
        background-color: #e0e0e0;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .article-container {
            margin: 20px auto;
        }
        
        .article-title {
            font-size: 2rem;
        }
        
        .article-content {
            padding: 25px;
        }
        
        .article-actions {
            flex-direction: column;
        }
    }
</style>

<div class="article-container">
    <?php flash('article_success'); ?>
    <?php flash('article_error'); ?>
    
    <div class="article-header">
        <a href="<?php echo URLROOT; ?>/child/articles" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Articles
        </a>
        
        <h1 class="article-title"><?php echo $data['article']->title; ?></h1>
        
        <div class="article-meta">
            <div class="article-author">
                <i class="fas fa-user"></i> <?php echo $data['article']->author_name; ?>
            </div>
            <div class="article-date">
                <i class="far fa-calendar-alt"></i> <?php echo date('F j, Y', strtotime($data['article']->created_at)); ?>
            </div>
        </div>
    </div>
    
    <?php if($data['article']->image_url) : ?>
        <img src="<?php echo $data['article']->image_url; ?>" alt="<?php echo $data['article']->title; ?>" class="article-featured-image">
    <?php endif; ?>
    
    <div class="article-content">
        <?php echo $data['article']->content; ?>
    </div>
    
    <div class="article-actions">
        <?php if($data['article']->user_id == $_SESSION['user_id']) : ?>
            <a href="<?php echo URLROOT; ?>/child/editArticle/<?php echo $data['article']->article_id; ?>" class="action-btn edit-btn">
                <i class="fas fa-pencil-alt"></i> Edit Article
            </a>
            <a href="<?php echo URLROOT; ?>/child/deleteArticle/<?php echo $data['article']->article_id; ?>" class="action-btn delete-btn">
                <i class="fas fa-trash-alt"></i> Delete Article
            </a>
        <?php endif; ?>
        
        <a href="<?php echo URLROOT; ?>/child/articles" class="action-btn back-to-articles">
            <i class="fas fa-list"></i> All Articles
        </a>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
