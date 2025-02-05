<?php require APPROOT.'/views/inc/components/header.php';?>
<h1>Users</h1>
<?php foreach($data['users'] as $user) : ?>
    <p><?php echo $user->users_name; ?> - <?php echo $user->users_address ?></p>
<?php endforeach; ?>
<?php require APPROOT.'/views/inc/components/footer.php';?>

