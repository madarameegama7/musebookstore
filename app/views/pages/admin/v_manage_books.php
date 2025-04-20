<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php flash('admin_msg'); ?> <!-- Display flash messages -->

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1><?php echo $data['title']; ?></h1>
            <a href="<?php echo URLROOT; ?>/admin/createBook" class="btn btn-update" style="margin-bottom: 10px;">Add New Book</a> <!-- Use btn-update for green or define btn-add -->
        </div>

        <p>Here you can manage all listed books.</p>

        <table>
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Owner</th>
                    <th>Posted Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['books'] as $book) : ?>
                    <tr>
                        <td><?php echo $book->book_id; ?></td>
                        <td><?php echo htmlspecialchars($book->book_title ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($book->book_author ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($book->owner_name ?? 'N/A'); ?> (ID: <?php echo $book->owner_id; ?>)</td>
                        <td><?php echo isset($book->created_at) ? date('Y-m-d', strtotime($book->created_at)) : 'N/A'; ?></td>
                        <td>
                            <a href="<?php echo URLROOT; ?>/admin/viewBook/<?php echo $book->book_id; ?>" class="btn-view">View Details</a>
                            <a href="<?php echo URLROOT; ?>/admin/editBook/<?php echo $book->book_id; ?>" class="btn-edit">Edit</a>
                            <form action="<?php echo URLROOT; ?>/admin/deleteBook/<?php echo $book->book_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this book? This action cannot be undone.');">
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>