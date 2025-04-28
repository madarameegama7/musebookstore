<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php require APPROOT . '/views/inc/components/parent/sidebar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<div class="booktoken-container">
    <main>
    <?php flash('payment_message'); ?>
        <h2 class="main-title">
            <center>Buy tokens for unlimited book swappings</center>
        </h2>
        <p class="subtitle">
            This is the best way to get unlimited access to books
        </p>
        <div class="pricing-cards">

            <div class="card highlight">
                <h3>
                    Muse Tokens
                </h3>
                <div class="price">
                    Rs.200
                </div>
                <ul>
                    <li>
                        <i class="fas fa-check">
                        </i>
                        Upto 5 book transactions
                    </li>
                    <li>
                        <i class="fas fa-check">
                        </i>
                        No expiration period
                    </li>
                    <li>
                        <i class="fas fa-check">
                        </i>
                        Unlimited access to books
                    </li>
                    <li>
                        <i class="fas fa-check">
                        </i>
                        Renew at anytime
                    </li>
                    <li>
                        <i class="fas fa-check">
                        </i>
                        Get reward points
                    </li>
                </ul>
                <a class="cta highlight" href="<?php echo URLROOT?>/books/makePayment" >
                    Purchase Token
                </a>

            </div>
        </div>
    </main>
</div>
