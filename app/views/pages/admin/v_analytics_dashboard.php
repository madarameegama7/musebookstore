<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <p>Search for users or books within the system.</p>
        <?php flash('admin_msg'); ?>

        <div class="search-forms">
            <!-- User Search Form -->
            <div class="search-card">
                <h2>Search Users</h2>
                <form action="<?php echo URLROOT; ?>/admin/analyticsDashboard" method="post">
                    <input type="hidden" name="search_type" value="users">
                    <label for="user_search_term">Search by ID, Name, or Email:</label>
                    <input type="text" name="search_term" id="user_search_term" value="<?php echo ($data['search_type'] == 'users') ? htmlspecialchars($data['search_term'] ?? '') : ''; ?>" placeholder="Enter search term...">
                    <button type="submit" class="btn-search">Search Users</button>
                </form>
            </div>

            <!-- Book Search Form -->
            <div class="search-card">
                <h2>Search Books</h2>
                <form action="<?php echo URLROOT; ?>/admin/analyticsDashboard" method="post">
                    <input type="hidden" name="search_type" value="books">
                    <label for="book_search_term">Search by ID, Title, Author, ISBN, Owner ID/Name:</label>
                    <input type="text" name="search_term" id="book_search_term" value="<?php echo ($data['search_type'] == 'books') ? htmlspecialchars($data['search_term'] ?? '') : ''; ?>" placeholder="Enter search term...">
                    <button type="submit" class="btn-search">Search Books</button>
                </form>
            </div>
        </div>

        <hr>

        <!-- Display User Search Results -->
        <?php if ($data['search_type'] == 'users' && !empty($data['search_term'])) : ?>
            <h2>User Search Results for "<?php echo htmlspecialchars($data['search_term'] ?? ''); ?>"</h2>
            <?php if (!empty($data['user_results'])) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['user_results'] as $user) : ?>
                            <tr>
                                <td><?php echo $user->user_id; ?></td>
                                <td><?php echo htmlspecialchars($user->user_name ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($user->user_email ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($user->user_role ?? ''); ?></td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/admin/viewUser/<?php echo $user->user_id; ?>" class="btn-view">View</a>
                                    <?php if ($user->user_id != $_SESSION['user_id']) : ?>
                                        <a href="<?php echo URLROOT; ?>/admin/editUser/<?php echo $user->user_id; ?>" class="btn-edit">Edit</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No users found matching your search criteria.</p>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Display Book Search Results -->
        <?php if ($data['search_type'] == 'books' && !empty($data['search_term'])) : ?>
            <h2>Book Search Results for "<?php echo htmlspecialchars($data['search_term'] ?? ''); ?>"</h2>
            <?php if (!empty($data['book_results'])) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Owner</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['book_results'] as $book) : ?>
                            <tr>
                                <td><?php echo $book->book_id; ?></td>
                                <td><?php echo htmlspecialchars($book->book_title ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($book->book_author ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($book->owner_name ?? 'N/A'); ?> (ID: <?php echo $book->owner_id; ?>)</td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/admin/viewBook/<?php echo $book->book_id; ?>" class="btn-view">View</a>
                                    <a href="<?php echo URLROOT; ?>/admin/editBook/<?php echo $book->book_id; ?>" class="btn-edit">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No books found matching your search criteria.</p>
            <?php endif; ?>
        <?php endif; ?>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>