<?php require APPROOT.'/views/inc/header.php';?>
<h1>Users</h1>
<?php foreach($data['user'] as $user) : ?>
    <p><?php echo $user->user_name; ?> - <?php echo $user->user_address ?></p>
<?php endforeach; ?>
<?php require APPROOT.'/views/inc/footer.php';?>

