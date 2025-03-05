<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<h1><?php echo $_SESSION['user_name'];?></h1>

<div class="articles-container">
        <h2>Books</h2>
        <div class="articles">
            <?php foreach($data['books'] as $book):?>
            <div class="articles-card">
            <img src="/musebookstore/public/img/index-page.jpg">
                <h3><?php echo $book->book_title; ?></h3>
                <p>By <?php echo $book->book_author; ?></p>
                <p><?php echo $book->book_genre; ?></p>
                <?php if($book->user_id ==$_SESSION['user_id']):?>
                <div class="book-ctrl-button">
                    <a href="<?php echo URLROOT?>/books/edit/<?php echo $book->book_id?>"><button class="book-ctrl-btn">Edit</button></a>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <br>
        <a href="#" id="showMoreBtn">Show More Articles</a>
</div>