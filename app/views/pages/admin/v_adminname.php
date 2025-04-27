<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <?php
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
            die("Access denied! You do not have permission to view this page.");
        }
        ?>
        <h1>Admin Name</h1>
        <h2>Welcome <?php echo $_SESSION['user_role']; ?></h2>
    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>