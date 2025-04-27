<?php require APPROOT.'/views/inc/header.php'; ?>
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!-- Link to external CSS -->
<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/eventDetails.css">

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ambassador') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<div class="event-details-main">
    <div class="event-details-container">
        <h1 class="event-details-title">Event Details</h1>

        <?php if (isset($data['event'])): ?>
            <div class="event-details-box">
                <h2 class="event-name"><?php echo $data['event']->event_name; ?></h2>
                <p class="event-description"><strong>Description:</strong> <?php echo $data['event']->event_description; ?></p>
                <p class="event-location"><strong>Location:</strong> <?php echo $data['event']->event_place; ?></p>
                <p class="event-date"><strong>Date:</strong> <?php echo $data['event']->event_date; ?></p>
                <p class="event-time"><strong>Time:</strong> <?php echo $data['event']->event_time; ?></p>

                <!-- Google Maps Embed -->
                <div class="event-map">
                    <iframe
                        width="100%"
                        height="300"
                        frameborder="0"
                        style="border:0; border-radius: 8px;"
                        src="https://www.google.com/maps?q=<?php echo urlencode($data['event']->event_place); ?>&output=embed"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        <?php else: ?>
            <p class="event-not-found">No event data found.</p>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
