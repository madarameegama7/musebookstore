<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php require APPROOT . '/views/inc/components/parent/sidebar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<h2>Payment Successful!</h2>
<p>Thank you for your payment of Rs. 200.</p>
<a href="<?php echo URLROOT; ?>/Parent/dashboard">Go back to Dashboard</a>
