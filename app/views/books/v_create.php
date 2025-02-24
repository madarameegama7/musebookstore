<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role'])) {
    die("Please login");
}
?>

<div class="addbook-container">
    <div class="addbook-photo">
        <img src="/musebookstore/public/img/books/book-reading.jpg" alt="Muse Bookstore Logo">
    </div>

    <div class="addbook-box">
        <form action="<?php echo URLROOT;?>/Books/create" method="post">
            <label>Book Title</label><br>
            <input type="text" name="booktitle" id="booktitle" placeholder="Enter Book Title" value="<?php $data['booktitle']; ?>" required>
            <span class="form-invalid"><?php echo $data['book_title_err'];?></span>
            <br>

            <label>Author</label><br>
            <input type="text" name="author" id="author" placeholder="Enter Author" value="<?php $data['author']; ?>" required>
            <span class="form-invalid"><?php echo $data['book_author_err'];?></span>
            <br>

            <label>Genre</label><br>
            <input type="text" name="genre" id="genre" placeholder="Enter Genre" value="<?php $data['genre']; ?>" required>
            <span class="form-invalid"><?php echo $data['book_genre_err'];?></span>
            <br>

            <label>Condition</label><br>
            <select class="bookcondition" name="bookcondition" required>
                <option value="new" <?php if ($data['bookcondition'] == 'new') 'selected'; ?>>New</option>
                <option value="used" <?php if ($data['bookcondition'] == 'used') 'selected'; ?>>Used</option>
            </select>
            <span class="form-invalid"><?php echo $data['book_condition_err'];?></span>
            <br>

            <label>Price in Rs.</label><br>
            <input type="number" name="price" id="price" placeholder="Enter price of book" value="<?php $data['price']; ?>" required>
            <span class="form-invalid"><?php echo $data['book_price_err'];?></span>
            <br>

            <label>Option</label><br>
            <select class="bookoption" name="bookoption" required>
                <option value="sell" <?php if ($data['bookoption'] == 'sell') 'selected'; ?>>Sell</option>
                <option value="swap" <?php if ($data['bookoption'] == 'swap') 'selected'; ?>>Swap</option>
            </select>
            <span class="form-invalid"><?php echo $data['book_option_err'];?></span>
            <br><br>

            <button type="submit" name="add-book-btn" class="add-book-btn">Add Book</button>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
