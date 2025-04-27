<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <a href="#addEventForm" class="btn btn-update" style="margin-bottom: 15px;">Add Event</a>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Place</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Community</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['events'])): ?>
                    <?php foreach ($data['events'] as $e): ?>
                        <tr>
                            <td><?php echo $e->event_id; ?></td>
                            <td><?php echo htmlspecialchars($e->event_name ?? ''); ?></td>
                            <td><?php echo htmlspecialchars(substr($e->event_description ?? '', 0, 40)); ?>...</td>
                            <td><?php echo htmlspecialchars($e->event_place ?? ''); ?></td>
                            <td><?php echo $e->event_date; ?></td>
                            <td><?php echo $e->event_time; ?></td>
                            <td><?php echo htmlspecialchars($e->communityName ?? ''); ?></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/editEvent/<?php echo $e->event_id; ?>" class="btn btn-edit">Edit</a>
                                <form action="<?php echo URLROOT; ?>/admin/deleteEvent/<?php echo $e->event_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete this event?');">
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <hr>
        <h2 id="addEventForm">Add Event</h2>
        <form action="<?php echo URLROOT; ?>/admin/addEvent" method="post" class="admin-form">
            <label for="event_name">Name:</label>
            <input type="text" id="event_name" name="event_name" required>
            <label for="event_description">Description:</label>
            <textarea id="event_description" name="event_description" required></textarea>
            <label for="event_place">Place:</label>
            <input type="text" id="event_place" name="event_place" required>
            <label for="event_date">Date:</label>
            <input type="date" id="event_date" name="event_date" required>
            <label for="event_time">Time:</label>
            <input type="time" id="event_time" name="event_time" required>
            <label for="community_id">Community ID:</label>
            <input type="number" id="community_id" name="community_id" required>
            <button type="submit" class="btn btn-update">Add Event</button>
        </form>
        <a href="<?php echo URLROOT; ?>/admin" class="btn btn-back" style="margin-top: 15px;">Back to Dashboard</a>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>