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
    <p>Tokens <strong><?php echo $data['token']->token_count; ?></strong></p>
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
                <a class="cta highlight" href="#" onclick="paymentGateway(event)">
                    Purchase Token
                </a>

            </div>
        </div>
    </main>
</div>

<script src="https://www.payhere.lk/lib/payhere.js"></script>
<script>
    function paymentGateway() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var obj = JSON.parse(xhttp.responseText);

            var payment = {
                "sandbox": true,
                "merchant_id": obj.merchant_id,
                "return_url": "<?php echo URLROOT; ?>/books/bookhistory",
                "cancel_url": "<?php echo URLROOT?>/books/bookhistory",
                "notify_url": "<?php echo URLROOT?>/books/payherenotify",
                "order_id": obj.order_id,
                "items": obj.items,
                "amount": obj.amount,
                "currency": obj.currency,
                "hash": obj.hash,
                "first_name": obj.first_name,
                "last_name": obj.last_name,
                "email": obj.email,
                "phone": obj.phone,
                "address": obj.address,
                "city": obj.city,
                "country": "Sri Lanka"
            };

            payhere.onCompleted = function(orderId) {
                alert("Payment completed. OrderID: " + orderId);
            };

            payhere.onDismissed = function() {
                alert("Payment dismissed.");
            };

            payhere.onError = function(error) {
                alert("Error: " + error);
            };

            payhere.startPayment(payment);
        }
    };
    xhttp.open("GET", "<?php echo URLROOT; ?>/books/tokenpayment", true);
    xhttp.send();
}

</script>