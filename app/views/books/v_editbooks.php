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
    <form action="<?php echo URLROOT; ?>/Books/edit/<?php echo $data['bookid']; ?>" method="post">
            <label>Book Title</label><br>
            <input type="text" name="booktitle" id="booktitle" placeholder="Enter Book Title"
                value="<?php echo $data['booktitle']; ?>" required>
            <span class="form-invalid"><?php echo $data['book_title_err']; ?></span>
            <br>

            <label>Author</label><br>
            <input type="text" name="author" id="author" placeholder="Enter Author" value="<?php echo $data['author']; ?>"
                required>
            <span class="form-invalid"><?php echo $data['book_author_err']; ?></span>
            <br>

            <label>Genre</label><br>
            <select class="genre" name="genre" required>
                <option value="Arts / Design" <?php if ($data['genre'] == 'Arts-Design')
                    echo 'selected'; ?>>Arts / Design
                </option>
                <option value="Biography / Memoir" <?php if ($data['genre'] == 'Biography-Memoir')
                    echo 'selected'; ?>>
                    Biography / Memoir</option>
                <option value="Business" <?php if ($data['genre'] == 'Business')
                    echo 'selected'; ?>>Business</option>
                <option value="Career / Success" <?php if ($data['genre'] == 'Career-Success')
                    echo 'selected'; ?>>Career
                    / Success</option>
                <option value="Communication" <?php if ($data['genre'] == 'Communication')
                    echo 'selected'; ?>>
                    Communication</option>
                <option value="Economics" <?php if ($data['genre'] == 'Economics')
                    echo 'selected'; ?>>Economics</option>
                <option value="Education" <?php if ($data['genre'] == 'Education')
                    echo 'selected'; ?>>Education</option>
                <option value="Entrepreneurship" <?php if ($data['genre'] == 'Entrepreneurship')
                    echo 'selected'; ?>>
                    Entrepreneurship</option>
                <option value="Entertainment" <?php if ($data['genre'] == 'Entertainment')
                    echo 'selected'; ?>>
                    Entertainment</option>
                <option value="Fiction" <?php if ($data['genre'] == 'Fiction')
                    echo 'selected'; ?>>Fiction</option>
                <option value="Food" <?php if ($data['genre'] == 'Food')
                    echo 'selected'; ?>>Food</option>
                <option value="Health" <?php if ($data['genre'] == 'Health')
                    echo 'selected'; ?>>Health</option>
                <option value="History" <?php if ($data['genre'] == 'History')
                    echo 'selected'; ?>>History</option>
                <option value="Law" <?php if ($data['genre'] == 'Law')
                    echo 'selected'; ?>>Law</option>
                <option value="Lifestyle" <?php if ($data['genre'] == 'Lifestyle')
                    echo 'selected'; ?>>Lifestyle</option>
                <option value="Leadership" <?php if ($data['genre'] == 'Leadership')
                    echo 'selected'; ?>>Leadership
                </option>
                <option value="Marketing" <?php if ($data['genre'] == 'Marketing')
                    echo 'selected'; ?>>Marketing</option>
                <option value="Media" <?php if ($data['genre'] == 'Media')
                    echo 'selected'; ?>>Media</option>
                <option value="Money/Finance" <?php if ($data['genre'] == 'Money-Finance')
                    echo 'selected'; ?>>
                    Money/Finance</option>
                <option value="Philosophy" <?php if ($data['genre'] == 'Philosophy')
                    echo 'selected'; ?>>Philosophy
                </option>
                <option value="Parenting" <?php if ($data['genre'] == 'Parenting')
                    echo 'selected'; ?>>Parenting</option>
                <option value="Politics" <?php if ($data['genre'] == 'Politics')
                    echo 'selected'; ?>>Politics</option>
                <option value="Productivity" <?php if ($data['genre'] == 'Productivity')
                    echo 'selected'; ?>>Productivity
                </option>
                <option value="Psychology" <?php if ($data['genre'] == 'Psychology')
                    echo 'selected'; ?>>Psychology
                </option>
                <option value="Relationships" <?php if ($data['genre'] == 'Relationships')
                    echo 'selected'; ?>>
                    Relationships</option>
                <option value="Sales" <?php if ($data['genre'] == 'Sales')
                    echo 'selected'; ?>>Sales</option>
                <option value="Science" <?php if ($data['genre'] == 'Science')
                    echo 'selected'; ?>>Science</option>
                <option value="Self-Improvement" <?php if ($data['genre'] == 'Self-Improvement')
                    echo 'selected'; ?>>
                    Self-Improvement</option>
                <option value="Society/Culture" <?php if ($data['genre'] == 'Society-Culture')
                    echo 'selected'; ?>>
                    Society/Culture</option>
                <option value="Spirituality" <?php if ($data['genre'] == 'Spirituality')
                    echo 'selected'; ?>>Spirituality
                </option>
                <option value="Sports" <?php if ($data['genre'] == 'Sports')
                    echo 'selected'; ?>>Sports</option>
                <option value="Technology" <?php if ($data['genre'] == 'Technology')
                    echo 'selected'; ?>>Technology
                </option>
            </select>
            <span class="form-invalid"><?php echo $data['book_genre_err']; ?></span>
            <br>

            <label>Condition</label><br>
                  <select class="bookcondition" name="bookcondition" required>
                <option value="new" <?php if ($data['bookcondition'] == 'new')
                    echo 'selected'; ?>>New</option>
                <option value="used" <?php if ($data['bookcondition'] == 'used')
                    echo 'selected'; ?>>Used</option>
            </select>
            <span class="form-invalid"><?php echo $data['book_condition_err']; ?></span>
            <br>

            <label>Price in Rs.</label><br>
            <input type="number" name="price" id="price" placeholder="Enter price of book"
                value="<?php echo $data['price']; ?>" required>
            <span class="form-invalid"><?php echo $data['book_price_err']; ?></span>
            <br>

            <label>Option</label><br>
            <select class="bookoption" name="bookoption" required>
                <option value="sell" <?php if ($data['bookoption'] == 'sell')
                    echo 'selected'; ?>>Sell</option>
                <option value="swap" <?php if ($data['bookoption'] == 'swap')
                    echo 'selected'; ?>>Swap</option>
            </select>
            <span class="form-invalid"><?php echo $data['book_option_err']; ?></span>
            <br><br>

            <button type="submit" name="update-book-btn" class="update-book-btn" value="update">Update Book</button>

        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>