<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role'])) {
    die("Please login");
}
?>

<div class="main-content">
    <div class="profile-container">
        <h1>Create a New Community</h1>

        <?php if (!empty($data['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($data['error']); ?></p>
        <?php endif; ?>

        <?php if (!empty($data['success'])): ?>
            <p class="success"><?php echo htmlspecialchars($data['success']); ?></p>
        <?php endif; ?>

        <form method="POST" action="<?php echo URLROOT; ?>/communities/add_members" enctype="multipart/form-data" class="community-form">
    
    <label for="user_id">Select Member:</label>
    <select id="user_id" name="user_id" required>
        <option value="">-- Select a User --</option>
        <?php foreach ($data['users'] as $user): ?>
            <option value="<?php echo $user->id; ?>">
                <?php echo htmlspecialchars($user->name); ?> (<?php echo htmlspecialchars($user->email); ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label for="community_id">Community ID:</label>
    <input type="text" id="community_id" name="community_id" value="<?php echo $data['community_id']; ?>" readonly>


    <button type="submit" class="submit-btn">Add Member</button>
      </form>

    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
