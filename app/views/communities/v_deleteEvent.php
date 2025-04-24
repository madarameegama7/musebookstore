<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<!-- Link unique CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/v_deleteEvent.css">

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ambassador') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<div class="delete-event-container">
    <h2 class="delete-event-title">Delete Event</h2>
    <p class="delete-event-message">
        Are you sure you want to delete <strong>"<?php echo $data['event']->event_name; ?>"</strong>?
    </p>

    <form class="delete-event-form" action="<?php echo URLROOT; ?>/communities/deleteEvent/<?php echo $data['event']->event_id; ?>" method="post">
        <button type="submit" class="btn-delete-event">Yes, Delete</button>
        <a href="<?php echo URLROOT; ?>/communities/viewEvent/<?php echo $data['event']->community_id; ?>" class="btn-cancel-delete">Cancel</a>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
