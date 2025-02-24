<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>
<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<section class="hero">
            <h1>Learn faster. Get smarter.</h1>
            <h2>Welcome to <br>Muse Bookstore</h2>
            <p>Your go-to platform for swapping, selling, and buying books. <br>
                Connect with fellow book lovers and expand your library today!</p>
                <br>
            <a href="<?php echo URLROOT?>/books/create" class="cta-button">Browse Books</a>
</section>

<?php require APPROOT.'/views/inc/footer.php';?>