<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <form action="<?php echo URLROOT; ?>/admin/editEvent/<?php echo $data['event']->event_id; ?>" method="post" class="admin-form">
            <label for="event_name">Name:</label>
            <input type="text" id="event_name" name="event_name" value="<?php echo $data['event']->event_name; ?>" required>

            <label for="event_description">Description:</label>
            <textarea id="event_description" name="event_description" required><?php echo $data['event']->event_description; ?></textarea>

            <label for="event_place">Place:</label>
            <input type="text" id="event_place" name="event_place" value="<?php echo $data['event']->event_place; ?>" required>

            <label for="event_date">Date:</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo $data['event']->event_date; ?>" required>

            <label for="event_time">Time:</label>
            <input type="time" id="event_time" name="event_time" value="<?php echo $data['event']->event_time; ?>" required>

            <label for="community_id">Community ID:</label>
            <input type="number" id="community_id" name="community_id" value="<?php echo $data['event']->community_id; ?>" required>

            <button type="submit" class="btn btn-update">Update Event</button>
        </form>
        <a href="<?php echo URLROOT; ?>/admin/manageEvents" class="btn btn-back" style="margin-top: 15px;">Back to Events</a>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>