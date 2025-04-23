<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <a href="<?php echo URLROOT; ?>/admin/manageBooks" class="btn btn-back"><i class="fa fa-arrow-left"></i> Back to Books</a>

        <?php flash('admin_msg'); ?>

        <h2><?php echo $data['title']; ?></h2>
        <p>Add a new book to the system.</p>

        <form class="edit-book-form" action="<?php echo URLROOT; ?>/admin/createBook" method="post">

            <label for="booktitle">Book Title: <sup>*</sup></label>
            <input type="text" name="booktitle" id="booktitle" value="<?php echo htmlspecialchars($data['booktitle']); ?>" required>
            <span class="form-invalid"><?php echo $data['book_title_err']; ?></span>

            <label for="author">Author: <sup>*</sup></label>
            <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($data['author']); ?>" required>
            <span class="form-invalid"><?php echo $data['book_author_err']; ?></span>

            <label for="publisher">Publisher: <sup>*</sup></label>
            <input type="text" name="publisher" id="publisher" value="<?php echo htmlspecialchars($data['publisher']); ?>" required>
            <span class="form-invalid"><?php echo $data['book_publisher_err']; ?></span>

            <label for="year">Year of Publication: <sup>*</sup></label>
            <input type="number" name="year" id="year" value="<?php echo htmlspecialchars($data['year']); ?>" required min="1000" max="<?php echo date('Y'); ?>">
            <span class="form-invalid"><?php echo $data['book_year_err']; ?></span>

            <label for="isbn">ISBN: <sup>*</sup></label>
            <input type="text" name="isbn" id="isbn" value="<?php echo htmlspecialchars($data['isbn']); ?>" required>
            <span class="form-invalid"><?php echo $data['book_isbn_err']; ?></span>

            <label for="genre">Genre: <sup>*</sup></label>
            <select class="genre" name="genre" id="genre" required>
                <option value="" disabled <?php echo empty($data['genre']) ? 'selected' : ''; ?>>Select Genre</option>
                <!-- Copy options from v_edit_book.php -->
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
            </select>
            <span class="form-invalid"><?php echo $data['book_genre_err']; ?></span>

            <label for="bookcondition">Condition: <sup>*</sup></label>
            <select class="bookcondition" name="bookcondition" id="bookcondition" required>
                <option value="" disabled <?php echo empty($data['bookcondition']) ? 'selected' : ''; ?>>Select Condition</option>
                <option value="new" <?php if ($data['bookcondition'] == 'new') echo 'selected'; ?>>New</option>
                <option value="used" <?php if ($data['bookcondition'] == 'used') echo 'selected'; ?>>Used</option>
            </select>
            <span class="form-invalid"><?php echo $data['book_condition_err']; ?></span>

            <label for="price">Price (Rs.): <sup>*</sup></label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($data['price']); ?>" required min="0" step="0.01">
            <span class="form-invalid"><?php echo $data['book_price_err']; ?></span>

            <label for="bookoption">Listing Type: <sup>*</sup></label>
            <select class="bookoption" name="bookoption" id="bookoption" required>
                <option value="" disabled <?php echo empty($data['bookoption']) ? 'selected' : ''; ?>>Select Option</option>
                <option value="sell" <?php if ($data['bookoption'] == 'sell') echo 'selected'; ?>>Sell</option>
                <option value="swap" <?php if ($data['bookoption'] == 'swap') echo 'selected'; ?>>Swap</option>
            </select>
            <span class="form-invalid"><?php echo $data['book_option_err']; ?></span>

            <label for="owner_id">Owner: <sup>*</sup></label>
            <select name="owner_id" id="owner_id" required>
                <option value="" disabled <?php echo empty($data['owner_id']) ? 'selected' : ''; ?>>Select Owner</option>
                <?php foreach ($data['users'] as $user): ?>
                    <option value="<?php echo $user->user_id; ?>" <?php if ($data['owner_id'] == $user->user_id) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($user->user_name) . ' (' . htmlspecialchars($user->user_email) . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="form-invalid"><?php echo $data['owner_id_err']; ?></span>


            <button type="submit" class="btn btn-update">Add Book</button>
        </form>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>