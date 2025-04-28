<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">
<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>
    <main class="admin-main-content">
        <h1>Add New Community</h1>
        <?php flash('admin_msg'); ?>
        <form action="<?php echo URLROOT; ?>/admin/addCommunity" method="post" class="admin-form" style="max-width: 600px;">
            <label for="communityName">Community Name:</label>
            <input type="text" id="communityName" name="communityName" required>

            <label for="communityDescription">Description:</label>
            <textarea id="communityDescription" name="communityDescription" required></textarea>

            <label for="communityImage">Image URL:</label>
            <input type="text" id="communityImage" name="communityImage" placeholder="public/img/community/sample.jpg">

            <label for="membership_type">Membership Type:</label>
            <select id="membership_type" name="membership_type" required>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>

            <button type="submit" class="btn btn-update">Add Community</button>
        </form>
        <a href="<?php echo URLROOT; ?>/admin/manageCommunities" class="btn btn-back" style="margin-top: 15px;">Back to Communities</a>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>