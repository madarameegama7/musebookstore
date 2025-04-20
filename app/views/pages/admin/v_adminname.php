<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<h1>Admin Name</h1>

<h1>Welcome <?php echo $_SESSION['user_role']; ?></h1>

<?php require APPROOT . '/views/inc/footer.php'; ?>