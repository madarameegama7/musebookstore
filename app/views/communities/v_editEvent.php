<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Link to unique CSS for this page -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/v_editEvent.css">

<div class="edit-event-container">
    <h2 class="edit-event-title">Edit Event</h2>
    
    <form class="edit-event-form" action="<?php echo URLROOT; ?>/communities/editEvent/<?php echo $data['event']->event_id; ?>" method="post">
        
        <div class="edit-event-form-group">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" class="edit-event-input" value="<?php echo $data['event']->event_name; ?>" required>
        </div>

        <div class="edit-event-form-group">
            <label for="event_description">Description:</label>
            <textarea name="event_description" class="edit-event-input" rows="4"><?php echo $data['event']->event_description; ?></textarea>
        </div>

        <div class="edit-event-form-group">
            <label for="event_place">Location:</label>
            <input type="text" name="event_place" class="edit-event-input" value="<?php echo $data['event']->event_place; ?>" required>
        </div>

        <div class="edit-event-form-group">
            <label for="event_date">Date:</label>
            <input type="date" name="event_date" class="edit-event-input" value="<?php echo $data['event']->event_date; ?>" required>
        </div>

        <div class="edit-event-form-group">
            <label for="event_time">Time:</label>
            <input type="time" name="event_time" class="edit-event-input" value="<?php echo $data['event']->event_time; ?>" required>
        </div>

        <button type="submit" class="edit-event-btn">Update</button>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
