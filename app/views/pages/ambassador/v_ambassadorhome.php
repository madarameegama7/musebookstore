<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>
<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ambassador') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<section class="hero">
    <div class="index-content">
        <h1>Connect, share, and grow </h1>
        <h2>Welcome to <br>Communities</h2>
        Explore our vibrant book communities <br>
        <p>with like-minded readers today!</p>
    </div>
    <div class="index-top-image">
        <img src="/musebookstore/public/img/index-page.jpg">
    </div>
</section>
<a href="<?php echo URLROOT?>/communities/display" class="cta-button">Explore Communities</a>

<?php require APPROOT.'/views/inc/footer.php';?>