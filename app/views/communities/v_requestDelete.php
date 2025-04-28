<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>


<div class="delete-community-container">
    <div class="delete-community-form-card">
        <h2 class="delete-community-title">Request to Delete Community</h2>

        <?php if (!empty($data['error'])): ?>
            <p class="delete-community-error"><?php echo $data['error']; ?></p>
        <?php endif; ?>

        <form action="<?php echo URLROOT; ?>/communities/requestDelete/<?php echo $data['community']->communityId; ?>" method="POST">
            <label class="delete-community-label">Community Name:</label>
            <input class="delete-community-input" type="text" value="<?php echo $data['community']->communityName; ?>" readonly>

            <label class="delete-community-label">Type:</label>
            <input class="delete-community-input" type="text" value="<?php echo $data['community']->membership_type; ?>" readonly>

            <label class="delete-community-label">Description:</label>
            <textarea class="delete-community-textarea" readonly><?php echo $data['community']->communityDescription; ?></textarea>

            <label class="delete-community-label">Reason for Deletion:</label>
            <textarea class="delete-community-textarea" name="reason" required placeholder="Enter your reason here..."></textarea>

            <button class="delete-community-button" type="submit">Submit Delete Request</button>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
