<div class="articles-container">
        <h2>Books</h2>
        <div class="articles">
            <?php foreach($data['books'] as $book):?>
            <div class="articles-card">
            <img src="/musebookstore/public/img/index-page.jpg">
                <h3><?php echo $book->book_title; ?></h3>
                <p>By <?php echo $book->book_author; ?></p>
                <p><?php echo $book->book_genre; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <br>
        <a href="#" id="showMoreBtn">Show More Articles</a>
</div>