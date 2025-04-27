<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.querySelector('input[name="event_date"]');
        const timeInput = document.querySelector('input[name="event_time"]');

        // Get today's date
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months start at 0
        const dd = String(today.getDate()).padStart(2, '0');
        const todayStr = `${yyyy}-${mm}-${dd}`;

        // Set min date
        dateInput.min = todayStr;

        // Disable past times if today is selected
        dateInput.addEventListener('change', function () {
            if (dateInput.value === todayStr) {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                timeInput.min = `${hours}:${minutes}`;
            } else {
                timeInput.removeAttribute('min');
            }
        });

        // Trigger change if a value already exists
        if (dateInput.value === todayStr) {
            dateInput.dispatchEvent(new Event('change'));
        }
    });
</script>

<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<!-- Link to unique CSS for this page -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/v_createEvent.css">

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ambassador') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<div class="create-event-main-content">
    <div class="create-event-form-container">
        <h1 class="create-event-title"><center>Create Event</center></h1>

        <?php if (!empty($data['error'])): ?>
            <div class="create-event-alert create-event-error"><?php echo $data['error']; ?></div>
        <?php endif; ?>

        <?php if (!empty($data['success'])): ?>
            <div class="create-event-alert create-event-success"><?php echo $data['success']; ?></div>
        <?php endif; ?>

        <form class="create-event-form" action="<?php echo isset($data['community_id']) ? URLROOT . '/communities/createEvent/' . $data['community_id'] : '#'; ?>" method="POST">

            <div class="create-event-form-group">
                <label for="event_name">Event Name:</label>
                <input type="text" name="event_name" class="create-event-form-control" value="<?php echo $data['event_name'] ?? ''; ?>" required>
            </div>

            <div class="create-event-form-group">
                <label for="event_description">Event Description:</label>
                <textarea name="event_description" class="create-event-form-control" rows="4"><?php echo $data['event_description'] ?? ''; ?></textarea>
            </div>

            <div class="create-event-form-group">
                <label for="event_place">Event Location:</label>
                <input type="text" name="event_place" class="create-event-form-control" value="<?php echo $data['event_place'] ?? ''; ?>" required>
            </div>

            <div class="create-event-form-group">
                <label for="event_date">Event Date:</label>
                <input type="date" name="event_date" class="create-event-form-control" value="<?php echo $data['event_date'] ?? ''; ?>" required>
            </div>

            <div class="create-event-form-group">
                <label for="event_time">Event Time:</label>
                <input type="time" name="event_time" class="create-event-form-control" value="<?php echo $data['event_time'] ?? ''; ?>" required>
            </div>

            <input type="submit" value="Create Event" class="create-event-btn create-event-btn-primary">
            <a href="<?php echo isset($data['community_id']) ? URLROOT . '/communities/viewEvents/' . $data['community_id'] : '#'; ?>" class="create-event-btn create-event-btn-secondary">Back to Events</a>

        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
