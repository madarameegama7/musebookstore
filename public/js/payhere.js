function paymentGateway() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var obj = JSON.parse(xhttp.responseText);

            var payment = {
                "sandbox": true,
                "merchant_id": obj.merchant_id,
                "return_url": "<?php echo URLROOT?>/books/booktoken",
                "cancel_url": "<?php echo URLROOT?>/books/booktoken",
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
    xhttp.open("GET", "<?php echo URLROOT?>/books/booktoken", true);
    xhttp.send();
}
