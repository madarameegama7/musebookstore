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
        background: linear-gradient(135deg, #FF5722 0%, #FF9800 100%);
        color: white;
        padding: 40px;
        border-radius: 15px 15px 0 0;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
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
        font-size: 2.8rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .articles-header p {
        margin: 10px 0 0;
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .articles-nav {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        background-color: white;
        border-radius: 50px;
        padding: 5px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .articles-nav a {
        padding: 12px 25px;
        text-decoration: none;
        color: #555;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
    }
    
    .articles-nav a.active {
        background-color: #FF5722;
        color: white;
        box-shadow: 0 3px 10px rgba(255, 87, 34, 0.3);
    }
    
    .articles-nav a:hover:not(.active) {
        background-color: #f0f0f0;
        color: #333;
    }
    
    .articles-intro {
        background-color: #fff;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    
    .articles-intro p {
        margin: 0 0 20px;
        font-size: 1.1rem;
        color: #555;
        line-height: 1.7;
    }
    
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 25px;
    }
    
    .create-article-btn {
        display: inline-block;
        background: linear-gradient(135deg, #FF5722 0%, #FF9800 100%);
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 87, 34, 0.3);
    }
    
    .create-article-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(255, 87, 34, 0.4);
    }
    
    .view-drafts-btn {
        display: inline-block;
        background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }
    
    .view-drafts-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(76, 175, 80, 0.4);
    }
    
    .articles-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }
    
    .article-card {
        background-color: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    
    .article-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }
    
    .article-controls {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        gap: 8px;
        z-index: 10;
    }
    
    .article-control-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }
    
    .edit-btn {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    }
    
    .edit-btn:hover {
        transform: scale(1.1);
    }
    
    .delete-btn {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }
    
    .delete-btn:hover {
        transform: scale(1.1);
    }
    
    .article-image {
        height: 220px;
        background-color: #f5f5f5;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .article-image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50%;
        background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
    }
    
    .article-content {
        padding: 25px;
        position: relative;
    }
    
    .article-title {
        margin: 0 0 15px;
        font-size: 1.5rem;
        color: #333;
        line-height: 1.3;
    }
    
    .article-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 15px;
        color: #777;
        font-size: 0.9rem;
    }
    
    .article-author {
        margin-right: 15px;
        display: flex;
        align-items: center;
    }
    
    .article-author i {
        margin-right: 5px;
        color: #FF5722;
    }
    
    .article-date {
        margin-right: 15px;
        display: flex;
        align-items: center;
    }
    
    .article-date i {
        margin-right: 5px;
        color: #FF5722;
    }
    
    .article-status {
        display: inline-block;
        margin-right: 15px;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    
    .status-published {
        background-color: #2ecc71;
        color: white;
    }
    
    .status-draft {
        background-color: #95a5a6;
        color: white;
    }
    
    .article-excerpt {
        color: #555;
        margin-bottom: 20px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
    }
    
    .read-more {
        display: inline-block;
        background-color: #f5f5f5;
        color: #333;
        padding: 10px 20px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    
    .read-more:hover {
        background-color: #FF5722;
        color: white;
        transform: translateY(-2px);
    }
    
    .empty-articles {
        text-align: center;
        padding: 60px 30px;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }
    
    .empty-articles h3 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.8rem;
    }
    
    .empty-articles p {
        color: #666;
        margin-bottom: 25px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        font-size: 1.1rem;
        line-height: 1.6;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    @media (max-width: 768px) {
        .articles-list {
            grid-template-columns: 1fr;
        }
        
        .articles-header h1 {
            font-size: 2.2rem;
        }
        
        .articles-nav {
            flex-direction: column;
            padding: 10px;
            border-radius: 15px;
        }
        
        .articles-nav a {
            margin-bottom: 5px;
        }
    }
</style>

<div class="articles-container">
    <?php flash('article_success'); ?>
    <?php flash('article_error'); ?>
    
    <div class="articles-header">
        <h1>Young Writers' Corner</h1>
        <p>Explore creative writing by fellow readers and share your own stories, reviews, and thoughts</p>
    </div>
    
    <div class="articles-nav">
        <a href="#" class="active" data-tab="all-articles">All Articles</a>
        <a href="#" data-tab="my-articles">My Articles</a>
    </div>
    
    <div class="articles-intro">
        <p>Welcome to our vibrant community of young writers! Here you can discover articles, stories, and book reviews written by fellow readers like you. Get inspired by different perspectives and share your own creative writing with others.</p>
        
        <div class="action-buttons">
            <a href="<?php echo URLROOT; ?>/child/createArticle" class="create-article-btn">Write New Article</a>
            <a href="<?php echo URLROOT; ?>/child/myDrafts" class="view-drafts-btn">View My Drafts</a>
        </div>
    </div>
    
    <!-- All Articles Tab -->
    <div id="all-articles" class="tab-content active">
        <?php if(empty($data['articles'])) : ?>
            <div class="empty-articles">
                <h3>No articles available yet</h3>
                <p>Be the first to share your thoughts, stories, or book reviews with other readers!</p>
                <a href="<?php echo URLROOT; ?>/child/createArticle" class="create-article-btn">Write Your First Article</a>
            </div>
        <?php else : ?>
            <div class="articles-list">
                <?php foreach($data['articles'] as $article) : ?>
                    <div class="article-card">
                        <?php if($article->image_url) : ?>
                            <div class="article-image" style="background-image: url('<?php echo $article->image_url; ?>')"></div>
                        <?php else : ?>
                            <div class="article-image" style="background-image: url('<?php echo URLROOT; ?>/public/img/article-placeholder.jpg')"></div>
                        <?php endif; ?>
                        
                        <div class="article-content">
                            <h3 class="article-title"><?php echo $article->title; ?></h3>
                            
                            <div class="article-meta">
                                <span class="article-author"><i class="fas fa-user"></i> <?php echo $article->author_name; ?></span>
                                <span class="article-date"><i class="far fa-calendar"></i> <?php echo date('M j, Y', strtotime($article->created_at)); ?></span>
                            </div>
                            
                            <div class="article-excerpt">
                                <?php echo substr(strip_tags($article->content), 0, 150) . '...'; ?>
                            </div>
                            
                            <a href="<?php echo URLROOT; ?>/child/viewArticle/<?php echo $article->article_id; ?>" class="read-more">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- My Articles Tab -->
    <div id="my-articles" class="tab-content">
        <?php 
        // Get user's articles
        $myArticles = [];
        foreach($data['articles'] as $article) {
            if($article->user_id == $_SESSION['user_id']) {
                $myArticles[] = $article;
            }
        }
        ?>
        
        <?php if(empty($myArticles)) : ?>
            <div class="empty-articles">
                <h3>You haven't written any articles yet</h3>
                <p>Share your thoughts, stories, or book reviews with other readers. Your creative voice matters!</p>
                <a href="<?php echo URLROOT; ?>/child/createArticle" class="create-article-btn">Write Your First Article</a>
            </div>
        <?php else : ?>
            <div class="articles-list">
                <?php foreach($myArticles as $article) : ?>
                    <div class="article-card">
                        <div class="article-controls">
                            <a href="<?php echo URLROOT; ?>/child/editArticle/<?php echo $article->article_id; ?>" class="article-control-btn edit-btn"><i class="fas fa-pencil-alt"></i></a>
                            <a href="<?php echo URLROOT; ?>/child/deleteArticle/<?php echo $article->article_id; ?>" class="article-control-btn delete-btn"><i class="fas fa-trash"></i></a>
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
                                <span class="article-date"><i class="far fa-calendar"></i> <?php echo date('M j, Y', strtotime($article->created_at)); ?></span>
                            </div>
                            
                            <div class="article-excerpt">
                                <?php echo substr(strip_tags($article->content), 0, 150) . '...'; ?>
                            </div>
                            
                            <a href="<?php echo URLROOT; ?>/child/viewArticle/<?php echo $article->article_id; ?>" class="read-more">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('.articles-nav a');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabLinks.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                tabLinks.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to current tab
                this.classList.add('active');
                
                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
