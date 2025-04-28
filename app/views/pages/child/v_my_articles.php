<?php require APPROOT.'/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<style>
    .articles-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .articles-header {
        background-color: #E91E63;
        color: white;
        padding: 30px 40px;
        border-radius: 10px 10px 0 0;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .articles-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: skewX(-25deg);
    }
    
    .articles-header h1 {
        margin: 0;
        font-size: 2.5rem;
        font-weight: 600;
    }
    
    .articles-intro {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .articles-intro p {
        margin: 0 0 15px;
        font-size: 1.1rem;
        color: #555;
        line-height: 1.6;
    }
    
    .create-article-btn {
        display: inline-block;
        background-color: #E91E63;
        color: white;
        padding: 10px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .create-article-btn:hover {
        background-color: #C2185B;
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .articles-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }
    
    .article-card {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    .article-controls {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
    }
    
    .article-control-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .edit-btn {
        background-color: #3498db;
    }
    
    .edit-btn:hover {
        background-color: #2980b9;
    }
    
    .delete-btn {
        background-color: #e74c3c;
    }
    
    .delete-btn:hover {
        background-color: #c0392b;
    }
    
    .article-image {
        height: 200px;
        background-color: #f5f5f5;
        background-size: cover;
        background-position: center;
    }
    
    .article-content {
        padding: 20px;
    }
    
    .article-title {
        margin: 0 0 10px;
        font-size: 1.5rem;
        color: #333;
    }
    
    .article-meta {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        color: #777;
        font-size: 0.9rem;
    }
    
    .article-status {
        margin-right: 15px;
        background-color: #f5f5f5;
        padding: 3px 10px;
        border-radius: 15px;
        font-weight: 500;
    }
    
    .status-published {
        background-color: #2ecc71;
        color: white;
    }
    
    .status-draft {
        background-color: #95a5a6;
        color: white;
    }
    
    .article-date {
        margin-right: 15px;
    }
    
    .article-excerpt {
        color: #555;
        margin-bottom: 20px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
    }
    
    .read-more {
        display: inline-block;
        background-color: #f5f5f5;
        color: #333;
        padding: 8px 15px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    
    .read-more:hover {
        background-color: #E91E63;
        color: white;
    }
    
    .empty-articles {
        text-align: center;
        padding: 40px 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .empty-articles h3 {
        color: #333;
        margin-bottom: 15px;
    }
    
    .empty-articles p {
        color: #666;
        margin-bottom: 25px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    @media (max-width: 768px) {
        .articles-list {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="articles-container">
    <?php flash('article_success'); ?>
    <?php flash('article_error'); ?>
    
    <div class="articles-header">
        <h1><?php echo $data['page_title']; ?></h1>
    </div>
    
    <div class="articles-intro">
        <p>Welcome to your personal writing space! Here you can manage all the articles you've written. You can create new articles, edit existing ones, or remove articles you no longer want to share.</p>
        <a href="<?php echo URLROOT; ?>/child/createArticle" class="create-article-btn">Write New Article</a>
    </div>
    
    <?php if(empty($data['articles'])) : ?>
        <div class="empty-articles">
            <h3>You haven't written any articles yet</h3>
            <p>Share your thoughts, stories, or book reviews with other readers. It's easy and fun!</p>
            <a href="<?php echo URLROOT; ?>/child/createArticle" class="create-article-btn">Write Your First Article</a>
        </div>
    <?php else : ?>
        <div class="articles-list">
            <?php foreach($data['articles'] as $article) : ?>
                <div class="article-card">
                    <div class="article-controls">
                        <a href="<?php echo URLROOT; ?>/child/editArticle/<?php echo $article->article_id; ?>" class="article-control-btn edit-btn" title="Edit Article">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="<?php echo URLROOT; ?>/child/deleteArticle/<?php echo $article->article_id; ?>" class="article-control-btn delete-btn" title="Delete Article">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                    
                    <?php if($article->image_url) : ?>
                        <div class="article-image" style="background-image: url('<?php echo $article->image_url; ?>')"></div>
                    <?php else : ?>
                        <div class="article-image" style="background-image: url('<?php echo URLROOT; ?>/public/img/article-placeholder.jpg')"></div>
                    <?php endif; ?>
                    
                    <div class="article-content">
                        <h3 class="article-title"><?php echo $article->title; ?></h3>
                        
                        <div class="article-meta">
                            <span class="article-status status-<?php echo $article->status; ?>"><?php echo ucfirst($article->status); ?></span>
                            <span class="article-date"><?php echo date('M j, Y', strtotime($article->created_at)); ?></span>
                        </div>
                        
                        <div class="article-excerpt">
                            <?php echo substr(strip_tags($article->content), 0, 150) . '...'; ?>
                        </div>
                        
                        <a href="<?php echo URLROOT; ?>/child/viewArticle/<?php echo $article->article_id; ?>" class="read-more">Read Full Article</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
