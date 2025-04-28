<?php require APPROOT.'/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<style>
    .drafts-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
    }
    
    .page-header {
        background-color: #E91E63;
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }
    
    .btn-new-article {
        background-color: white;
        color: #E91E63;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-new-article:hover {
        background-color: #f8f8f8;
        transform: translateY(-2px);
    }
    
    .draft-article {
        background-color: #fff;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
        border-left: 4px solid #FFC107;
    }
    
    .draft-article:hover {
        transform: translateY(-5px);
    }
    
    .draft-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .draft-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    .draft-date {
        font-size: 0.9rem;
        color: #777;
    }
    
    .draft-content {
        margin-bottom: 20px;
        color: #555;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .draft-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-continue {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    
    .btn-continue:hover {
        background-color: #3e8e41;
    }
    
    .btn-publish {
        background-color: #2196F3;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    
    .btn-publish:hover {
        background-color: #0b7dda;
    }
    
    .btn-delete {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    
    .btn-delete:hover {
        background-color: #d32f2f;
    }
    
    .no-drafts {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
    }
    
    .no-drafts h3 {
        color: #555;
        margin-bottom: 15px;
    }
    
    .no-drafts p {
        color: #777;
        margin-bottom: 20px;
    }
</style>

<div class="drafts-container">
    <div class="page-header">
        <h1><?php echo $data['page_title']; ?></h1>
        <a href="<?php echo URLROOT; ?>/child/createArticle" class="btn-new-article">Write New Article</a>
    </div>
    
    <?php if(empty($data['drafts'])) : ?>
        <div class="no-drafts">
            <h3>You don't have any draft articles yet</h3>
            <p>Save your articles as drafts to continue writing them later.</p>
            <a href="<?php echo URLROOT; ?>/child/createArticle" class="btn-continue">Start Writing</a>
        </div>
    <?php else : ?>
        <?php foreach($data['drafts'] as $draft) : ?>
            <div class="draft-article">
                <div class="draft-header">
                    <h2 class="draft-title"><?php echo $draft->title; ?></h2>
                    <div class="draft-date">
                        <?php if($draft->updated_at) : ?>
                            Last edited: <?php echo date('M j, Y g:i A', strtotime($draft->updated_at)); ?>
                        <?php else : ?>
                            Created: <?php echo date('M j, Y g:i A', strtotime($draft->created_at)); ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="draft-content">
                    <?php echo strip_tags(substr($draft->content, 0, 200)) . '...'; ?>
                </div>
                
                <div class="draft-actions">
                    <a href="<?php echo URLROOT; ?>/child/editArticle/<?php echo $draft->article_id; ?>" class="btn-continue">Continue Writing</a>
                    <form method="POST" action="<?php echo URLROOT; ?>/child/publishDraft/<?php echo $draft->article_id; ?>" style="display:inline;">
                        <button type="submit" class="btn-publish">Publish Now</button>
                    </form>
                    <a href="<?php echo URLROOT; ?>/child/deleteArticle/<?php echo $draft->article_id; ?>" class="btn-delete">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
