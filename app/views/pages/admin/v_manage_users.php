<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <p>Here you can manage all registered users.</p>

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
                <?php foreach ($data['users'] as $user) : ?>
                    <tr>
                        <td><?php echo $user->user_id; ?></td>
                        <td><?php echo htmlspecialchars($user->user_name); ?></td>
                        <td><?php echo htmlspecialchars($user->user_email); ?></td>
                        <td><?php echo htmlspecialchars($user->user_role); ?></td>
                        <td>
                            <!-- Add View/Edit/Delete buttons later -->
                            <button>View</button>
                            <button>Edit</button>
                            <button>Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
