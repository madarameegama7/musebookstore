<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <a href="<?php echo URLROOT; ?>/admin/book/manageBooks" class="btn btn-back"><i class="fa fa-arrow-left"></i> Back to Books</a>

        <?php flash('admin_msg'); ?> <!-- Display flash messages if update fails on reload -->

        <h2><?php echo $data['title']; ?></h2>
        <p>Edit book details below.</p>

        <form class="edit-book-form" action="<?php echo URLROOT; ?>/admin/book/updateBook/<?php echo $data['bookid']; ?>" method="post">

            <label for="booktitle">Book Title: <sup>*</sup></label>
            <input type="text" name="booktitle" id="booktitle" value="<?php echo htmlspecialchars($data['booktitle'] ?? ''); ?>" required>
            <span class="form-invalid"><?php echo $data['book_title_err']; ?></span>

            <label for="author">Author: <sup>*</sup></label>
            <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($data['author'] ?? ''); ?>" required>
            <span class="form-invalid"><?php echo $data['book_author_err']; ?></span>

            <label for="publisher">Publisher: <sup>*</sup></label>
            <input type="text" name="publisher" id="publisher" value="<?php echo htmlspecialchars($data['publisher'] ?? ''); ?>" required>
            <span class="form-invalid"><?php echo $data['book_publisher_err']; ?></span>

            <label for="year">Year of Publication: <sup>*</sup></label>
            <input type="number" name="year" id="year" value="<?php echo htmlspecialchars($data['year']); ?>" required min="1000" max="<?php echo date('Y'); ?>">
            <span class="form-invalid"><?php echo $data['book_year_err']; ?></span>

            <label for="isbn">ISBN: <sup>*</sup></label>
            <input type="text" name="isbn" id="isbn" value="<?php echo htmlspecialchars($data['isbn']); ?>" required>
            <span class="form-invalid"><?php echo $data['book_isbn_err']; ?></span>

            <label for="genre">Genre: <sup>*</sup></label>
            <select class="genre" name="genre" id="genre" required>
                <!-- Reusing options from v_editbooks.php -->
                <option value="" disabled <?php echo empty($data['genre']) ? 'selected' : ''; ?>>Select Genre</option>
                <option value="Arts / Design" <?php if ($data['genre'] == 'Arts / Design') echo 'selected'; ?>>Arts / Design</option>
                <option value="Biography / Memoir" <?php if ($data['genre'] == 'Biography / Memoir') echo 'selected'; ?>>Biography / Memoir</option>
                <option value="Business" <?php if ($data['genre'] == 'Business') echo 'selected'; ?>>Business</option>
                <option value="Career / Success" <?php if ($data['genre'] == 'Career / Success') echo 'selected'; ?>>Career / Success</option>
                <option value="Communication" <?php if ($data['genre'] == 'Communication') echo 'selected'; ?>>Communication</option>
                <option value="Economics" <?php if ($data['genre'] == 'Economics') echo 'selected'; ?>>Economics</option>
                <option value="Education" <?php if ($data['genre'] == 'Education') echo 'selected'; ?>>Education</option>
                <option value="Entrepreneurship" <?php if ($data['genre'] == 'Entrepreneurship') echo 'selected'; ?>>Entrepreneurship</option>
                <option value="Entertainment" <?php if ($data['genre'] == 'Entertainment') echo 'selected'; ?>>Entertainment</option>
                <option value="Fiction" <?php if ($data['genre'] == 'Fiction') echo 'selected'; ?>>Fiction</option>
                <option value="Food" <?php if ($data['genre'] == 'Food') echo 'selected'; ?>>Food</option>
                <option value="Health" <?php if ($data['genre'] == 'Health') echo 'selected'; ?>>Health</option>
                <option value="History" <?php if ($data['genre'] == 'History') echo 'selected'; ?>>History</option>
                <option value="Law" <?php if ($data['genre'] == 'Law') echo 'selected'; ?>>Law</option>
                <option value="Lifestyle" <?php if ($data['genre'] == 'Lifestyle') echo 'selected'; ?>>Lifestyle</option>
                <option value="Leadership" <?php if ($data['genre'] == 'Leadership') echo 'selected'; ?>>Leadership</option>
                <option value="Marketing" <?php if ($data['genre'] == 'Marketing') echo 'selected'; ?>>Marketing</option>
                <option value="Media" <?php if ($data['genre'] == 'Media') echo 'selected'; ?>>Media</option>
                <option value="Money/Finance" <?php if ($data['genre'] == 'Money/Finance') echo 'selected'; ?>>Money/Finance</option>
                <option value="Philosophy" <?php if ($data['genre'] == 'Philosophy') echo 'selected'; ?>>Philosophy</option>
                <option value="Parenting" <?php if ($data['genre'] == 'Parenting') echo 'selected'; ?>>Parenting</option>
                <option value="Politics" <?php if ($data['genre'] == 'Politics') echo 'selected'; ?>>Politics</option>
                <option value="Productivity" <?php if ($data['genre'] == 'Productivity') echo 'selected'; ?>>Productivity</option>
                <option value="Psychology" <?php if ($data['genre'] == 'Psychology') echo 'selected'; ?>>Psychology</option>
                <option value="Relationships" <?php if ($data['genre'] == 'Relationships') echo 'selected'; ?>>Relationships</option>
                <option value="Sales" <?php if ($data['genre'] == 'Sales') echo 'selected'; ?>>Sales</option>
                <option value="Science" <?php if ($data['genre'] == 'Science') echo 'selected'; ?>>Science</option>
                <option value="Self-Improvement" <?php if ($data['genre'] == 'Self-Improvement') echo 'selected'; ?>>Self-Improvement</option>
                <option value="Society/Culture" <?php if ($data['genre'] == 'Society/Culture') echo 'selected'; ?>>Society/Culture</option>
                <option value="Spirituality" <?php if ($data['genre'] == 'Spirituality') echo 'selected'; ?>>Spirituality</option>
                <option value="Sports" <?php if ($data['genre'] == 'Sports') echo 'selected'; ?>>Sports</option>
                <option value="Technology" <?php if ($data['genre'] == 'Technology') echo 'selected'; ?>>Technology</option>
                <!-- Add other genres as needed -->
            </select>
            <span class="form-invalid"><?php echo $data['book_genre_err']; ?></span>

            <label for="bookcondition">Condition: <sup>*</sup></label>
            <select class="bookcondition" name="bookcondition" id="bookcondition" required>
                <option value="" disabled <?php echo empty($data['bookcondition']) ? 'selected' : ''; ?>>Select Condition</option>
                <option value="new" <?php echo ($data['bookcondition'] == 'new') ? 'selected' : ''; ?>>New</option>
                <option value="used" <?php echo ($data['bookcondition'] == 'used') ? 'selected' : ''; ?>>Used</option>
                <!-- Add other conditions if applicable -->
            </select>
            <span class="form-invalid"><?php echo $data['book_condition_err']; ?></span>

            <label for="price">Price (Rs.): <sup>*</sup></label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($data['price']); ?>" required min="0" step="0.01">
            <span class="form-invalid"><?php echo $data['book_price_err']; ?></span>

            <label for="bookoption">Listing Type: <sup>*</sup></label>
            <select class="bookoption" name="bookoption" id="bookoption" required>
                <option value="" disabled <?php echo empty($data['bookoption']) ? 'selected' : ''; ?>>Select Option</option>
                <option value="sell" <?php echo ($data['bookoption'] == 'sell') ? 'selected' : ''; ?>>Sell</option>
                <option value="swap" <?php echo ($data['bookoption'] == 'swap') ? 'selected' : ''; ?>>Swap</option>
                <!-- Add other options if applicable -->
            </select>
            <span class="form-invalid"><?php echo $data['book_option_err']; ?></span>

            <button type="submit" class="btn btn-update">Save Changes</button>
        </form>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>