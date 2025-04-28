<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <p>Welcome to the Admin Dashboard.</p>

        <div class="admin-dashboard-stats">
            <div class="stat-card">
                <h2>Total Users</h2>
                <p><?php echo $data['userCount']; ?></p>
                <a href="<?php echo URLROOT; ?>/admin/manageUsers" class="stat-link">Manage Users</a>
            </div>
            <div class="stat-card">
                <h2>Total Books Listed</h2>
                <p><?php echo $data['bookCount']; ?></p>
                <a href="<?php echo URLROOT; ?>/admin/manageBooks" class="stat-link">Manage Books</a>
            </div>
            <!-- Add more stat cards as needed -->
        </div>

        <!-- Optional: Add quick links or recent activity section here -->

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>