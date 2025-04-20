<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <p>Here you can manage all listed books.</p>

        <table>
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <!-- Removed ISBN Column -->
                    <th>Owner</th>
                    <th>Posted Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['books'] as $book) : ?>
                    <tr>
                        <td><?php echo $book->book_id; ?></td>
                        <td><?php echo htmlspecialchars($book->book_title ?? 'N/A'); ?></td> <!-- Use correct property: book_title -->
                        <td><?php echo htmlspecialchars($book->book_author ?? 'N/A'); ?></td> <!-- Use correct property: book_author -->
                        <!-- Removed ISBN Column -->
                        <td><?php echo htmlspecialchars($book->owner_name ?? 'N/A'); ?> (ID: <?php echo $book->owner_id; ?>)</td> <!-- Use correct property: owner_id -->
                        <td><?php echo isset($book->created_at) ? date('Y-m-d', strtotime($book->created_at)) : 'N/A'; ?></td> <!-- Use correct property: created_at -->
                        <td>
                            <!-- Add View/Edit/Delete buttons later -->
                            <button>View</button>
                            <button class="delete-btn">Delete</button> <!-- Added class for potential styling -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
