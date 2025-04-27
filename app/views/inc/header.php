<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/musebookstore/public/img/title.png" type="image/png">
    <title><?php echo SITENAME; ?></title>

    <link rel="stylesheet" href="/musebookstore/public/css/style.css">
    <link rel="stylesheet" href="/musebookstore/public/css/book-grid.css">
    <link rel="stylesheet" href="/musebookstore/public/css/components/custom-alerts.css">

    <link rel="stylesheet" href="/musebookstore/public/css/admin/admin_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom Alert JS will be loaded before closing body tag -->
</head>


<body>
    <?php
    // Initialize the Alert Helper if it exists
    if (class_exists('Alert_Helper')) {
        require_once APPROOT . '/helpers/Alert_Helper.php';
    }
    ?>