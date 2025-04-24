<?php

// Check if user is a logged-in parent
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}

// Retrieve user details from session
$merchant_id = "1230183";
$merchant_secret = "MTMyNjg4MjE4NjI0OTYwOTkzNjIxMTE2OTQ2NDUyMTA2NTg2NDY0NQ==";

// Retrieve parent/user details from session
$order_id = uniqid();
$user_id=$_SESSION['user_id'] ?? '';
$amount = 200.00;
$currency = "LKR";
$items = "Token";
$name = $_SESSION['user_name'] ?? '';
$email = $_SESSION['user_email'] ?? '';
$phone = $_SESSION['user_phone'] ?? '';
$address = $_SESSION['user_address'] ?? '';

// Generate hash (using session data)
$hash = strtoupper(
    md5(
        $merchant_id .
        $order_id .
        number_format($amount, 2, '.', '') .
        $currency .
        strtoupper(md5($merchant_secret))
    )
);

// Prepare response
$response = [
    "merchant_id" => $merchant_id,
    "order_id" => $order_id,
    "user_id"=>$user_id,
    "items" => $items,
    "amount" => $amount,
    "currency" => $currency,
    "hash" => $hash,
    "name" => $name,
    "email" => $email,
    "phone" => $phone,
    "address" => $address
];

header('Content-Type: application/json');
echo json_encode($response);
?>