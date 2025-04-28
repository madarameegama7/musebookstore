<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php require APPROOT . '/views/inc/components/parent/sidebar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<h1>Hii</h1>
<p>Tokens <strong><?php echo $data['token']->token_count; ?></strong></p>
<p><?php echo $data['book']->book_count?></p>