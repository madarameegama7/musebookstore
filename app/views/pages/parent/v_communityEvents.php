<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<div class="community-events-page">
    <div class="community-events-container">
        <h1 class="community-events-title">Community Events</h1>

        <?php if (!empty($data['error']) && $data['error'] == 'noevents'): ?>
            <p class="community-events-message error">No events found for this community.</p>
        <?php endif; ?>

        <div id="calendar"></div> 
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 600,
        events: [
            <?php foreach ($data['events'] as $event): ?>
            {
                title: '<?php echo $event->event_name; ?>',
                start: '<?php echo $event->event_date; ?>',
                url: '<?php echo URLROOT; ?>/communities/viewCommunityEventDetails/<?php echo $event->event_id; ?>'
            },
            <?php endforeach; ?>
        ]
    });

    calendar.render();
});
</script>

<style>
    #calendar {
        margin-top: 2rem;
        background: #fff;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>
