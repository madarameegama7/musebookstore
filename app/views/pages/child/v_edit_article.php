<?php require APPROOT.'/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<style>
    .edit-article-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .edit-article-header {
        background-color: #3498db;
        color: white;
        padding: 30px 40px;
        border-radius: 10px 10px 0 0;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .edit-article-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: skewX(-25deg);
    }
    
    .edit-article-header h1 {
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
        border-color: #3498db;
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
    
    .btn-update {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-update:hover {
        background-color: #2980b9;
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
        border-left: 4px solid #3498db;
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

<div class="edit-article-container">
    <div class="edit-article-header">
        <h1>Edit Article</h1>
    </div>
    
    <div class="article-form-container">
        <form action="<?php echo URLROOT; ?>/child/editArticle/<?php echo $data['article_id']; ?>" method="post">
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
                <button type="submit" class="btn-update">Update Article</button>
                <a href="<?php echo URLROOT; ?>/child/viewArticle/<?php echo $data['article_id']; ?>" class="btn-cancel">Cancel</a>
            </div>
        </form>
        
        <div class="article-tips">
            <h4>Tips for Improving Your Article</h4>
            <ul>
                <li>Make sure your title is clear and interesting</li>
                <li>Break up long paragraphs to improve readability</li>
                <li>Add examples or personal experiences to engage readers</li>
                <li>Check your spelling and grammar</li>
                <li>Consider including an image to make your article more attractive</li>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#article-editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'indent', 'outdent', '|', 'undo', 'redo'],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
