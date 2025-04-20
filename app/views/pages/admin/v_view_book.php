<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php flash('admin_msg'); ?> <!-- Display flash messages -->
        <h1><?php echo $data['title']; ?></h1>
        <a href="<?php echo URLROOT; ?>/admin/manageBooks" class="btn-back">Back to Book List</a>

        <div class="book-details-card">
            <h2>Book Information</h2>
            <p><strong>ID:</strong> <?php echo $data['book']->book_id; ?></p>
            <p><strong>Title:</strong> <?php echo htmlspecialchars($data['book']->book_title ?? 'N/A'); ?></p>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($data['book']->book_author ?? 'N/A'); ?></p>
            <p><strong>Genre:</strong> <?php echo htmlspecialchars($data['book']->book_genre ?? 'N/A'); ?></p>
            <p><strong>Condition:</strong> <?php echo htmlspecialchars($data['book']->book_condition ?? 'N/A'); ?></p>
            <p><strong>Price:</strong> <?php echo htmlspecialchars($data['book']->book_price ?? 'N/A'); ?></p>
            <p><strong>Listing Type:</strong> <?php echo htmlspecialchars($data['book']->listing_type ?? 'N/A'); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($data['book']->book_status ?? 'N/A'); ?></p>
            <p><strong>Posted Date:</strong> <?php echo isset($data['book']->created_at) ? date('Y-m-d H:i:s', strtotime($data['book']->created_at)) : 'N/A'; ?></p>

            <h2>Owner Information</h2>
            <p><strong>Owner ID:</strong> <?php echo $data['book']->owner_id; ?></p>
            <p><strong>Owner Name:</strong> <?php echo htmlspecialchars($data['book']->owner_name ?? 'N/A'); ?></p>
            <p><strong>Owner Email:</strong> <?php echo htmlspecialchars($data['book']->owner_email ?? 'N/A'); ?></p>
        </div>

        <div class="admin-actions">
            <form action="<?php echo URLROOT; ?>/admin/deleteBook/<?php echo $data['book']->book_id; ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this book? This action cannot be undone.');">
                <button type="submit" class="btn-delete">Delete Book</button>
            </form>
        </div>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>