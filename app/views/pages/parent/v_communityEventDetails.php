<?php require APPROOT.'/views/inc/header.php'; ?>
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/eventDetails.css">

<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
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

                <div class="join-event-button">
                    <?php if (isset($_GET['joined']) && $_GET['joined'] == 'true'): ?>
                        <button class="btn btn-secondary" disabled>Joined</button>
                    <?php else: ?>
                        <form action="<?php echo URLROOT; ?>/communities/joinEventAction" method="post">
                            <input type="hidden" name="event_id" value="<?php echo $data['event']->event_id; ?>">
                            <button type="submit" class="btn btn-primary">Join Event</button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        <?php else: ?>
            <p class="event-not-found">No event data found.</p>
        <?php endif; ?>

    </div>
</div>

<!-- Success Pop-up Modal -->
<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div id="successModal" class="modal" style="display:block;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>You have successfully joined the event! Wait for the updates</h2>
        </div>
    </div>
<?php endif; ?>

<?php require APPROOT.'/views/inc/footer.php'; ?>

<!-- Modal Styling and Script -->
<style>
    /* The Modal (background) */
    .modal {
        display: none; 
        position: fixed;
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        text-align: center;
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 16px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    // Function to close the modal
    function closeModal() {
        document.getElementById('successModal').style.display = "none";
    }

    // Automatically close the modal after 3 seconds
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        setTimeout(function() {
            document.getElementById('successModal').style.display = "none";
        }, 3000); // Close the modal after 3 seconds
    <?php endif; ?>
</script>
