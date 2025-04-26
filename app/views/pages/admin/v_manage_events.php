<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <?php flash('admin_msg'); ?>
        <a href="#addEventForm" class="btn">Add Event</a>
        <table>
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
                            <td><?php echo htmlspecialchars($e->event_name); ?></td>
                            <td><?php echo htmlspecialchars(substr($e->event_description, 0, 40)); ?>...</td>
                            <td><?php echo htmlspecialchars($e->event_place); ?></td>
                            <td><?php echo $e->event_date; ?></td>
                            <td><?php echo $e->event_time; ?></td>
                            <td><?php echo htmlspecialchars($e->communityName); ?></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/admin/editEvent/<?php echo $e->event_id; ?>" class="btn-update">Edit</a>
                                <form action="<?php echo URLROOT; ?>/admin/deleteEvent/<?php echo $e->event_id; ?>" method="post" style="display:inline;" onsubmit="return confirm('Delete this event?');">
                                    <button type="submit" class="btn-delete">Delete</button>
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
        <form action="<?php echo URLROOT; ?>/admin/addEvent" method="post">
            <label>Name: <input type="text" name="event_name" required></label><br>
            <label>Description: <textarea name="event_description" required></textarea></label><br>
            <label>Place: <input type="text" name="event_place" required></label><br>
            <label>Date: <input type="date" name="event_date" required></label><br>
            <label>Time: <input type="time" name="event_time" required></label><br>
            <label>Community ID: <input type="number" name="community_id" required></label><br>
            <button type="submit" class="btn-update">Add Event</button>
        </form>
        <a href="<?php echo URLROOT; ?>/admin" class="btn">Back to Dashboard</a>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>