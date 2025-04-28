<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php flash('admin_msg'); ?> <!-- Display flash messages -->

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1><?php echo $data['title']; ?></h1>
            <a href="<?php echo URLROOT; ?>/admin/book/createBook" class="btn btn-update" style="margin-bottom: 10px;">Add New Book</a>
        </div>

        <!-- Search Form -->
        <div class="search-container admin-search-container" style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <form action="<?php echo URLROOT; ?>/admin/book/manageBooks" method="get" style="display: flex; flex-grow: 1; gap: 10px;">
                <input type="text" name="search" id="bookSearchInput" placeholder="Search by Book ID, Title, Author, ISBN, Owner ID/Name..." value="<?php echo htmlspecialchars($data['searchTerm'] ?? ''); ?>" style="flex-grow: 1; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" class="btn btn-search" style="padding: 8px 15px; border-radius: 4px; cursor: pointer;">Search</button> <!-- Added Search Button -->
            </form>
            <!-- Clear button -->
            <?php if (!empty($data['searchTerm'])): ?>
                <a href="<?php echo URLROOT; ?>/admin/book/manageBooks" class="btn btn-grey" style="text-decoration: none; padding: 8px 15px; border-radius: 4px;">Clear</a>
            <?php endif; ?>
        </div>

        <p>Here you can manage all listed books.</p>

        <div id="book-results-container"> <!-- Container for results message -->
            <?php if (empty($data['books']) && !empty($data['searchTerm'])) : ?>
                <p>No books found matching your search term "<?php echo htmlspecialchars($data['searchTerm']); ?>".</p>
            <?php endif; ?>
        </div>

        <table class="admin-table">
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
            <tbody id="book-table-body"> <!-- ID can remain but is not used by JS now -->
                <?php if (!empty($data['books'])) : ?>
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
                <?php elseif (empty($data['books']) && empty($data['searchTerm'])) : ?>
                    <tr>
                        <td colspan="6" class="no-results">No books found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </main>
</div>

<!-- Removed JavaScript includes for live search -->
<!-- <script> const URLROOT = ... </script> -->
<!-- <script src="<?php echo URLROOT; ?>/js/admin_live_search.js"></script> -->

<?php require APPROOT . '/views/inc/footer.php'; ?>