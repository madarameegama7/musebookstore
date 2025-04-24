<!-- Updated Button -->
<button id="openModalBtn" class="add-member-btn-submit">Add New Member</button>

<!-- Modal -->
<div id="addMemberModal" class="add-member-modal">
  <div class="add-member-modal-content">
    <span class="add-member-close" id="closeModalBtn">&times;</span>

    <h2>Add Member to Community</h2>

    <?php if (!empty($data['error'])): ?>
      <div class="add-member-error-msg"><?php echo $data['error']; ?></div>
    <?php endif; ?>

    <?php if (!empty($data['success'])): ?>
      <div class="add-member-success-msg"><?php echo $data['success']; ?></div>
    <?php endif; ?>

    <form action="<?php echo URLROOT; ?>/communities/addMembers/<?php echo $data['community_id']; ?>" method="post" class="add-member-form-container">
      <label for="community_member_name">Member Name:</label>
      <input type="text" name="community_member_name" required>

      <label for="user_id">Select User:</label>
      <select name="user_id" required>
        <option value="">-- Select a user --</option>
        <?php foreach ($data['user'] as $user): ?>
          <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="add-member-btn-submit">Add Member</button>
    </form>
  </div>
</div>

<a href="<?php echo URLROOT; ?>/communities/details/<?php echo $data['community_id']; ?>" class="add-member-view-details-btn">⬅ Back to Community</a>
