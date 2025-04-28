<?php require APPROOT.'/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<style>
    .create-article-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .create-article-header {
        background-color: #E91E63;
        color: white;
        padding: 30px 40px;
        border-radius: 10px 10px 0 0;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .create-article-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: skewX(-25deg);
    }
    
    .create-article-header h1 {
        margin: 0;
        font-size: 2.2rem;
        font-weight: 600;
    }
    
    .article-form-container {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }
    
    .form-control:focus {
        border-color: #E91E63;
        outline: none;
    }
    
    .is-invalid {
        border-color: #e74c3c;
    }
    
    .invalid-feedback {
        color: #e74c3c;
        margin-top: 5px;
        font-size: 0.9rem;
    }
    
    .ck-editor__editable {
        min-height: 300px;
    }
    
    .form-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn-publish {
        background-color: #E91E63;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-publish:hover {
        background-color: #C2185B;
        transform: translateY(-2px);
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
    }
    
    .btn-cancel:hover {
        background-color: #e0e0e0;
    }
    
    .article-tips {
        background-color: #f9f9f9;
        border-left: 4px solid #E91E63;
        padding: 15px 20px;
        margin-top: 30px;
        border-radius: 0 8px 8px 0;
    }
    
    .article-tips h4 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #333;
    }
    
    .article-tips ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .article-tips li {
        margin-bottom: 8px;
        color: #555;
    }
    
    @media (max-width: 768px) {
        .form-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="create-article-container">
    <div class="create-article-header">
        <h1>Write New Article</h1>
    </div>
    
    <div class="article-form-container">
        <form action="<?php echo URLROOT; ?>/child/createArticle" method="post">
            <div class="form-group">
                <label for="title">Article Title</label>
                <input type="text" name="title" id="title" class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>" placeholder="Enter your article title">
                <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
            </div>
            
            <div class="form-group">
                <label for="image_url">Image URL (Optional)</label>
                <input type="text" name="image_url" id="image_url" class="form-control" value="<?php echo $data['image_url']; ?>" placeholder="Enter a URL for your article image">
                <small class="text-muted">Add an image to make your article more engaging</small>
            </div>
            
            <div class="form-group">
                <label for="content">Article Content</label>
                <textarea name="content" id="article-editor" class="form-control <?php echo (!empty($data['content_err'])) ? 'is-invalid' : ''; ?>" rows="10" placeholder="Write your article here..."><?php echo $data['content']; ?></textarea>
                <span class="invalid-feedback"><?php echo $data['content_err']; ?></span>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn-publish">Publish Article</button>
                <a href="<?php echo URLROOT; ?>/child/myArticles" class="btn-cancel">Cancel</a>
            </div>
        </form>
        
        <div class="article-tips">
            <h4>Tips for Writing a Great Article</h4>
            <ul>
                <li>Choose a clear and interesting title</li>
                <li>Start with an engaging introduction</li>
                <li>Use paragraphs to organize your thoughts</li>
                <li>Share your personal experiences and opinions</li>
                <li>End with a meaningful conclusion</li>
            </ul>
        </div>
    </div>
</div>


<?php require APPROOT.'/views/inc/footer.php'; ?>
